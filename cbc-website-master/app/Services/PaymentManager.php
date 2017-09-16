<?php
/**
 * Created by PhpStorm.
 * User: Romain
 * Date: 06/07/2015
 * Time: 11:32
 */

namespace CityByCitizen\Services;

use Carbon\Carbon;
use CityByCitizen\Payment;
use CityByCitizen\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use PhpSpec\Exception\Exception;
use ThunderArrow\MangoPay\Enums\SecureMode;
use ThunderArrow\MangoPay\Exceptions\MangoPayException;
use ThunderArrow\MangoPay\MangoPay;
use ThunderArrow\MangoPay\Money;
use ThunderArrow\MangoPay\Requests\CreateBankAccount;
use ThunderArrow\MangoPay\Requests\CreateBankwirePayout;
use ThunderArrow\MangoPay\Requests\CreateCardPreAuthorization;
use ThunderArrow\MangoPay\Requests\CreateCardRegistration;
use ThunderArrow\MangoPay\Requests\CreateDirectPreauthorizedPayin;
use ThunderArrow\MangoPay\Requests\CreateNaturalUser;
use ThunderArrow\MangoPay\Requests\CreateWallet;
use ThunderArrow\MangoPay\Requests\EditCardRegistration;
use ThunderArrow\MangoPay\Requests\EditNaturalUser;
use ThunderArrow\MangoPay\Requests\EditWallet;
use ThunderArrow\Rest\RestRequest;
use ThunderArrow\Validation\Services\SuperValidator;

class PaymentManager {
    function __construct() {
    }

    /**
     * @param $data
     * @return Payment
     */
    public function Create($data) {
        if($data instanceof Collection) {
            $payment = [];
            foreach($data as $item) $payment[] = $this->Create($item);
            return collect($payment);
        }
        $payment = Payment::create($data);
        return $payment;
    }

    /**
     * @param Payment $payment
     * @param User $user
     */
    public function AddUser(Payment $payment,User $user) {
        $payment->user()->associate($user);
        $payment->save();
    }


    /**
     * @param Request $request
     * @param MangoPay $mangoPay
     */
    public function CreateMangoAccount(MangoPay $mangoPay) {
        $user = Auth::user()->user;

        if(!$user->payment) {
            $req = new CreateNaturalUser($mangoPay);
            $req->FirstName = $user->firstname;
            $req->LastName = $user->lastname;
            $req->Address = $user->address->street . ' ' . $user->address->zipcode . ' ' . $user->address->city;
            $req->Birthday = (new Carbon($user->birthdate))->timestamp;
            $req->Nationality = $user->nationality;
            $req->CountryOfResidence = $user->address->country;
            $req->Email = $user->account->mail;
            $createUserResult = $req->execute();
            $payment = $this->Create(['user_mango_id' => $createUserResult->Id]);
            $this->AddUser($payment, $user);
        } else {
            $req = new EditNaturalUser($mangoPay,Payment::where('user_id','=',$user->id)->first()->user_mango_id);
            $req->FirstName = $user->firstname;
            $req->LastName = $user->lastname;
            $req->Address = $user->address->street . ' ' . $user->address->zipcode . ' ' . $user->address->city;
            $req->Birthday = (new Carbon($user->birthdate))->timestamp;
            $req->Nationality = $user->nationality;
            $req->CountryOfResidence = $user->address->country;
            $req->Email = $user->account->mail;
            $req->execute();
        }
    }

    public function chargeExperience($travel,$mangoPay) {
        $price = 100*$this->ComputePrice($travel->experience,$travel->persons);
        $traveler = Payment::where('user_id','=',$travel->traveler->id)->first();
        $citizen = Payment::where('user_id','=',$travel->citizen->id)->first();
        //Charge the PreAuthorized amount
        $req = new CreateDirectPreauthorizedPayin($mangoPay);
        $req->AuthorId =  $traveler->user_mango_id;
        $req->DebitedFunds =  new Money('EUR',$price);
        $req->Fees = new Money('EUR', $travel->persons*200);
        $req->CreditedUserId = $citizen->user_mango_id;
        $req->CreditedWalletId = $citizen->wallet_id;
        $req->PreauthorizationId = $travel->payment_preauth_id;
        $req->execute();

        //Create draw funds from wallet request
        $req = new CreateBankwirePayout($mangoPay);
        $req->AuthorId = $citizen->user_mango_id;
        $req->DebitedWalletId = $citizen->wallet_id;
        $req->BankAccountId = $citizen->bank_id;
        $req->Fees = new Money('EUR',0);
        $req->DebitedFunds = new Money('EUR',$price - $travel->persons*200);
        $req->BankWireRef = "CityByCitizen";
        $req->execute();
        $travel->state = 'done';
        $travel->save();
    }

    public function ComputePrice($experience,$people) {
        return number_format($experience->incurred_cost_per_person*$people+$experience->incurred_cost+2*$people,2);
    }


    public function RegisterAndPreAuthoriseCard($price, Request $request, MangoPay $mangoPay) {
        $user = Auth::user()->user->load('payment');
        $payment = Payment::where('user_id','=', $user->id)->first();

        if($payment == null) {
            $this->CreateMangoAccount($mangoPay);
            $user = Auth::user()->user->load('payment')->load('address');
            $payment = Payment::where('user_id','=', $user->id)->first();
        }

        try {
            //Create card registration
            $req = new CreateCardRegistration($mangoPay);
            $req->UserId = $payment->user_mango_id;
            $req->Currency = 'EUR';
            $req->CardType = $request->input('cardType');
            $reqResult = $req->execute();
        } catch (MangoPayException  $e) {
            $errors['mango'] = trans('utils/mangopay.errors.registration');
            $errors['mango_details'] = $e->getMessage();
            $errors['mango_suggest'] = trans('utils/mangopay.suggestions.registration');
            return $errors;
        }
        if($reqResult->Status != "CREATED") {
            $errors['mango'] = trans('utils/mangopay.errors.registration');
            $errors['mango_suggest'] = trans('utils/mangopay.suggestions.registration');
            return $errors;
        }

        try {
        $array = http_build_query([
            'data' => $reqResult->PreregistrationData,
            'accessKeyRef' => $reqResult->AccessKey,
            'cardNumber' => $request->input('cardNumber'),
            'cardExpirationDate' => $request->input('cardExpirationDate'),
            'cardCvx' => $request->input('cardCvx'),
        ]);
        $req = RestRequest::Post($reqResult->CardRegistrationURL,$array );
        $req->setHeader('Content-Type','application/x-www-form-urlencoded');
        $response = $req->send();
        } catch (Exception $e) {
            $errors['mango'] = trans('utils/mangopay.errors.preregistration');
            $errors['mango_details'] = $e->getMessage();
            $errors['mango_suggest'] = trans('utils/mangopay.suggestions.preregistration');
            return $errors;
        }
        if(!$response->body) {
            $errors['mango'] = trans('utils/mangopay.errors.preregistration');
            $errors['mango_suggest'] = trans('utils/mangopay.suggestions.preregistration');
            return $errors;
        }


        try {
        //Edit Registration data
        $authorisationId = $reqResult->Id;
        $req = new EditCardRegistration($mangoPay, $authorisationId);
        $req->RegistrationData = $response->body;
        $reqResult = $req->execute();
        } catch (MangoPayException $e) {
            $errors['mango'] = trans('utils/mangopay.errors.editregistration');
            $errors['mango_details'] = $e->getMessage();
            $errors['mango_suggest'] = trans('utils/mangopay.suggestions.editregistration');
            return $errors;
        }
        if($reqResult->Status == "ERROR") {
            $errors['mango'] =  trans('utils/mangopay.errors.editregistration');
            $errors['mango_suggest'] = trans('utils/mangopay.suggestions.editregistration');
            return $errors;
        }

        try {
        //Create card preauthorisation
        $req = new CreateCardPreAuthorization($mangoPay);
        $req->AuthorId = $payment->user_mango_id;
        $req->CardId = $reqResult->CardId;
        $req->DebitedFunds = new Money('EUR', $price*100);
        $req->SecureMode = SecureMode::UseDefault;
        $req->SecureModeReturnURL = action("BookingController@getIndex");
        $reqResult = $req->execute();
        } catch (MangoPayException $e) {
            $errors['mango'] =  trans('utils/mangopay.errors.preauthorisation');
            $errors['mango_details'] = $e->getMessage();
            $errors['mango_suggest'] = trans('utils/mangopay.suggestions.preauthorisation');
            return $errors;
        }
        if(!$reqResult->Status == "SUCCEEDED") {
            $errors['mango'] = trans('utils/mangopay.errors.preauthorisation');
            $errors['mango_suggest'] = trans('utils/mangopay.suggestions.preauthorisation');
            return $errors;
        }
        return $reqResult;
    }


    public function UpdateBanking(Request $request, MangoPay $mangoPay) {
        $validator = SuperValidator::make('Bank', $request->only(['iban', 'bic']));
        if ($validator->fails()) return $validator->errors()->all();

        $user = Auth::user()->user->load('payment')->load('address');
        $payment = Payment::where('user_id','=', $user->id)->first();

        if($payment == null) {
            $this->CreateMangoAccount($mangoPay);
            $user = Auth::user()->user->load('payment')->load('address');
            $payment = Payment::where('id','=', $user->payment->id)->first();
        }

        $data = $request->only(['iban','bic']);
        $address = $user->address;

        try {
            if(!$payment->wallet_id) {
                $req = new CreateWallet($mangoPay);
                $req->Currency = 'EUR';
                $req->Description = 'Citizen wallet';
                $req->Owners = [$payment->user_mango_id];
                $createWalletResult = $req->execute();
                $payment->wallet_id = $createWalletResult->Id;
            } else {
                $req = new EditWallet($mangoPay,$payment->wallet_id );
                $req->Description = 'Citizen wallet';
                $createWalletResult = $req->execute();

                $payment->wallet_id = $createWalletResult->Id;
            }
        } catch (MangoPayException $e) {
            $errors['mango'] = trans('utils/mangopay.errors.createupdatewallet');
            $errors['mango_details'] = $e->getMessage();
            $errors['mango_suggest'] = trans('utils/mangopay.suggestions.createupdatewallet');
            return $errors;
        }



        try {
            if(!$payment->bank_id) {
                $req = new CreateBankAccount($mangoPay,$payment->user_mango_id,'IBAN');
                $req->OwnerName = $user->lastname;
                $req->OwnerAddress =$address->street . ' ' . $address->zipcode . ' ' . $address->city;
                $req->IBAN = $data['iban'];
                $req->BIC = $data['bic'];
                $createBankAccountResult = $req->execute();
                $payment->bank_id = $createBankAccountResult->Id;
            } else {
                $req = new CreateBankAccount($mangoPay,$payment->user_mango_id,'IBAN');
                $req->OwnerName = $user->lastname;
                $req->OwnerAddress =$address->street . ' ' . $address->zipcode . ' ' . $address->city;
                $req->IBAN = $data['iban'];
                $req->BIC = $data['bic'];
                $createBankAccountResult = $req->execute();
                $payment->bank_id = $createBankAccountResult->Id;
            }
        } catch (MangoPayException $e) {
            $errors['mango'] =  trans('utils/mangopay.errors.createupdatebank');
            $errors['mango_details'] = $e->getMessage();
            $errors['mango_suggest'] = trans('utils/mangopay.suggestions.createupdatebank');
            return $errors;
        }

        $payment->save();
        return null;
    }

}
