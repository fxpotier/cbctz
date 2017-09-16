@include('emails.fragments.salutation', ['name' => $data['traveler']['firstname']])
@lang('view/booking/emails.content.traveler.reminder.remind', ['experience' => $data['experience'], 'time' => $data['time'], 'citizen' => $data['citizen']['firstname']])<br><br>
@lang('view/booking/emails.content.traveler.reminder.contact',['citizen' => $data['citizen']['firstname']])<br><br>
@lang('view/booking/emails.content.common.contact')<br><br>
@lang('view/booking/emails.content.common.mail', ['email' => $data['citizen']['mail']])<br/>
@lang('view/booking/emails.content.common.phone', ['phone' => $data['citizen']['phone']])<br/><br/>
@lang('view/booking/emails.content.traveler.reminder.tip')<br><br>
@lang('fragment/emails/courtesy.common.valediction.standard')<br/><br/>
@include('emails.fragments.signature')