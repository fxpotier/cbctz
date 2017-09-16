@include('emails.fragments.salutation', ['name' => $data['citizen']['firstname']])
@lang('view/booking/emails.content.citizen.denied.deny', ['experience' => $data['experience'], 'date' => $data['date'], 'time' => $data['time'], 'traveler' => $data['traveler']['firstname']])<br><br>
@lang('view/booking/emails.content.citizen.denied.agenda')<br><br>
@lang('fragment/emails/courtesy.common.valediction.standard')<br/><br/>
@include('emails.fragments.signature')