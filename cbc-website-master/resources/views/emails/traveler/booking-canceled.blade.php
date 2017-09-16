@include('emails.fragments.salutation', ['name' => $data['traveler']['firstname']])
@lang('view/booking/emails.content.traveler.canceled.cancel', ['experience' => $data['experience'], 'date' => $data['date'], 'time' => $data['time'], 'citizen' => $data['citizen']['firstname']])<br><br>
@lang('view/booking/emails.content.traveler.canceled.info')<br><br>
@lang('fragment/emails/courtesy.common.valediction.standard')<br/><br/>
@include('emails.fragments.signature')