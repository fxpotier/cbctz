@include('emails.fragments.salutation', ['name' => $data['citizen']['firstname']])
@lang('view/booking/emails.content.citizen.feedback.start', ['experience' => $data['experience'], 'traveler' => $data['traveler']['firstname']])<br><br>
@lang('view/booking/emails.content.citizen.feedback.feedback', ['traveler' => $data['traveler']['firstname']])<br><br>
@lang('view/booking/emails.content.common.feedback')
@lang('fragment/emails/courtesy.common.emails.feedback')<br/><br/>
@lang('fragment/emails/courtesy.common.valediction.standard')<br/><br/>
@include('emails.fragments.signature')