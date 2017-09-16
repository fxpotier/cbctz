@include('emails.fragments.salutation', ['name' => $data['traveler']['firstname']])
@lang('view/booking/emails.content.traveler.feedback.start', ['experience' => $data['experience'], 'citizen' => $data['citizen']['firstname']])<br><br>
@lang('view/booking/emails.content.traveler.feedback.feedback', ['citizen' => $data['citizen']['firstname']])<br><br>
@lang('view/booking/emails.content.common.feedback')
@lang('fragment/emails/courtesy.common.emails.feedback')<br/><br/>
@lang('fragment/emails/courtesy.common.valediction.standard')<br/><br/>
@include('emails.fragments.signature')