<?php
/**
 * Created by PhpStorm.
 * User: Romain
 * Date: 10/07/2015
 * Time: 14:38
 */

return [
    'errors' => [
        'registration' =>'The payment transaction failed at the registration step.',
        'preregistration' =>'The payment transaction failed at the card registration step.',
        'editregistration' =>'The payment transaction failed at the card registration validation step.',
        'preauthorisation' =>'The payment transaction failed at the card payment pre-authorization step.',
        'createupdatewallet' => 'The mangopay wallet creation or edition has failed.',
        'createupdatebank' =>'The mangopay bank account creation or edition has failed.',
    ],
    'success' => [
        'editbanking' =>'Your banking informations have been successfuly updated.',
    ],
    'suggestions' => [
        'registration' =>'Please verify that the card informations you entered are correct.',
        'preregistration' =>'Please verify that the card informations you entered are correct.',
        'editregistration' =>'Please verify that the card informations you entered are correct.',
        'preauthorisation' =>'Please verify that you have the required funds in your account.',
        'createupdatewallet' => 'Please contact our support if the problem occurs again.',
        'createupdatebank' =>'Please verify that the IBAN and BIC you wrote are correct.',
    ],
    'titles' => [
        'error' => 'Transaction error',
        'editsuccess' => 'Banking Informations updated'
    ],
];