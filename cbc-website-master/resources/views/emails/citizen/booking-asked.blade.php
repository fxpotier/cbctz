@include('emails.fragments.salutation', ['name' => $data['citizen']['firstname']])
@lang('view/booking/emails.content.citizen.asked.reservation', ['experience' => $data['experience'], 'date' => $data['date'], 'time' => $data['time'], 'traveler' => $data['traveler']['firstname']])<br><br>
@lang('view/booking/emails.content.citizen.asked.confirm')<br><br>
<a href="{{action('BookingController@getIndex')}}">@lang('view/booking/emails.content.common.bookings')</a><br/><br/>
@lang('fragment/emails/courtesy.common.valediction.standard')<br/><br/>
@include('emails.fragments.signature')