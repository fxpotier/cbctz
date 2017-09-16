@extends('layouts.base')

@section('title')
	@lang('fragment/auth/reset.meta.title')
@endsection

@section('description')
	@lang('fragment/auth/reset.meta.description')
@endsection

@section('body')
	<h1>@lang('fragment/auth/reset.title')</h1>
	<form method="post" action="{{action('AccountController@postResetPassword', [$token])}}">
		<input type="hidden" name="_token" value="{{csrf_token()}}"/>

		{{$errors->first('password')}}
		<div class="form-group has-feedback {{$errors->first('password') ? 'has-error' : ''}}">
			<input type="password" class="form-control input-lg" name="password" placeholder="@lang('fragment/auth/reset.inputs.password')" required>
			<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
		</div>

		<div class="form-group has-feedback">
			<input type="password" class="form-control input-lg" name="password_confirmation" placeholder="@lang('fragment/auth/reset.inputs.password_confirm')" required>
			<span class="glyphicon glyphicon-lock form-control-feedback"></span>
		</div>

		<input value="@lang('fragment/auth/reset.inputs.submit')" class="btn btn-info btn-lg btn-block" type="submit"/>
	</form>
@endsection