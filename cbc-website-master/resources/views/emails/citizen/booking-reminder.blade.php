@include('emails.fragments.salutation', ['name' => $data['citizen']['firstname']])
@lang('view/booking/emails.content.citizen.reminder.remind', ['experience' => $data['experience'], 'time' => $data['time'], 'traveler' => $data['traveler']['firstname']])<br><br>
@lang('view/booking/emails.content.citizen.reminder.contact',['traveler' => $data['traveler']['firstname']])<br><br>
@lang('view/booking/emails.content.common.contact')<br><br>
@lang('view/booking/emails.content.common.mail', ['email' => $data['traveler']['mail']])<br/>
@lang('view/booking/emails.content.common.phone', ['phone' => $data['traveler']['phone']])<br/><br/>
@lang('view/booking/emails.content.citizen.reminder.tip')<br><br>
@lang('fragment/emails/courtesy.common.valediction.standard')<br/><br/>
@include('emails.fragments.signature')