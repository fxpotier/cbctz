@extends('layouts.base-no-container')

@section('scripts')
	<script type="text/javascript" src="{{asset('js/auth.js')}}"></script>
@endsection

@section('title')
	@lang('fragment/auth/signin.meta.title')
@endsection

@section('description')
	@lang('fragment/auth/signin.meta.description')
@endsection

@section('body')
	<div class="background-gray">
	    <div class="container" ng-controller="signin" ng-init="csrf_token='{{csrf_token()}}'">
	        <br/>
	        <br/>
	        <div class="col-lg-8 col-lg-offset-2 col-md-8 col-md-offset-2">
                @include('fragments.auth.sign-in', ['name' => 'City by citizen', 'social' => ['facebook']])
                <br/>
	        </div>
	    </div>
	</div>
@endsection