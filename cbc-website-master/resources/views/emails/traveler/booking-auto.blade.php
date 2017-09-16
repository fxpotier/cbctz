@include('emails.fragments.salutation', ['name' => $data['traveler']['firstname']])
@lang('view/booking/emails.content.traveler.common.reservation', ['experience' => $data['experience'], 'date' => $data['date'], 'time' => $data['time'], 'citizen' => $data['citizen']['firstname']])
@lang('view/booking/emails.content.traveler.auto')
@lang('view/booking/emails.content.traveler.common.contact', ['citizen' => $data['citizen']['firstname']])<br/><br/>
@lang('view/booking/emails.content.common.contact')<br/>
@lang('view/booking/emails.content.common.mail', ['email' => $data['citizen']['mail']])<br/>
@lang('view/booking/emails.content.common.phone', ['phone' => $data['citizen']['phone']])<br/><br/>
@lang('view/booking/emails.content.traveler.common.tip')
@lang('fragment/emails/courtesy.common.valediction.wish')<br/><br/>
@include('emails.fragments.signature')