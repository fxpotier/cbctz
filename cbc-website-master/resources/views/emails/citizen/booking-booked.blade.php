@include('emails.fragments.salutation', ['name' => $data['citizen']['firstname']])
@lang('view/booking/emails.content.citizen.booked.confirm', ['experience' => $data['experience'], 'date' => $data['date'], 'time' => $data['time'], 'traveler' => $data['traveler']['firstname']])<br><br>
@lang('view/booking/emails.content.citizen.common.contact',['traveler' => $data['traveler']['firstname']])<br><br>
@lang('view/booking/emails.content.common.contact')<br><br>
@lang('view/booking/emails.content.common.mail', ['email' => $data['traveler']['mail']])<br/>
@lang('view/booking/emails.content.common.phone', ['phone' => $data['traveler']['phone']])<br/><br/>
@lang('fragment/emails/courtesy.common.valediction.wish')<br/><br/>
@include('emails.fragments.signature')