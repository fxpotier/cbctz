@include('emails/fragments/salutation', ['name' => $name])
@lang('fragment/auth/emails.reset.confirm') :<br/>
<a href="{{action('AccountController@getResetPassword', [$token])}}">@lang('fragment/auth/emails.reset.link')</a><br/><br/>
@include('emails/fragments/signature')