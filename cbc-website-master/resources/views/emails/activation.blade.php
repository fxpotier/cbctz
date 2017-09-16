@include('emails/fragments/salutation', ['name' => $name])
@lang('fragment/auth/emails.activate.content')<br/><br/>
@lang('fragment/auth/emails.activate.confirm-account')
<a href="{{action('AccountController@getActivate', [$token,$url])}}">@lang('fragment/auth/emails.activate.link')</a><br/><br/>
@lang('fragment/emails/courtesy.common.valediction.farewell')<br/><br/>
@include('emails/fragments/signature')