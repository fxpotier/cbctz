@extends('layouts.base')

@section('title')
	@lang('fragment/auth/forgot.meta.title')
@endsection

@section('description')
	@lang('fragment/auth/forgot.meta.description')
@endsection

@section('body')
	<h1>@lang('fragment/auth/forgot.title')</h1>
	<form method="post" action="{{action('AccountController@postForgotPassword')}}">
		<input type="hidden" name="_token" value="{{csrf_token()}}"/>

		@if (isset($error))
			<div class="alert alert-danger">
				{{$error}}
			</div>
		@endif
		<div class="form-group has-feedback {{isset($error) ? 'has-error' : ''}}">
			<input type="email" class="form-control input-lg" name="mail" placeholder="@lang('fragment/auth/forgot.inputs.email')" value="{{$input['mail'] or ''}}" required>
			<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
		</div>

		<input value="@lang('fragment/auth/forgot.inputs.submit')" class="btn btn-info btn-lg btn-block" type="submit"/>
	</form>

	<span>@lang('fragment/auth/forgot.not_yet') <a href="{{action('AccountController@getSignUp')}}">@lang('fragment/auth/forgot.signup')</a></span>
@endsection