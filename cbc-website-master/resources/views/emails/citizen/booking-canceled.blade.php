@include('emails.fragments.salutation', ['name' => $data['citizen']['firstname']])
@lang('view/booking/emails.content.citizen.canceled.cancel', ['experience' => $data['experience'], 'date' => $data['date'], 'time' => $data['time'], 'traveler' => $data['traveler']['firstname']])<br><br>
@lang('view/booking/emails.content.citizen.canceled.info')<br><br>
@lang('fragment/emails/courtesy.common.valediction.standard')<br/><br/>
@include('emails.fragments.signature')