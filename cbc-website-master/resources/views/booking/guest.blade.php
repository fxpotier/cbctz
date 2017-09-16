@extends('layouts.base-no-container')

@section('styles')
    <link rel="stylesheet" href="{{asset('css/booking.css')}}"/>
@endsection

@section('title')
@lang('view/booking/guest.meta.title')
@endsection

@section('description')
@lang('view/booking/guest.meta.description')
@endsection

@section('body')
	<div class="background-gray guest">
	    <div class="container">
	        <div class="h1 text-primary">@lang('view/booking/guest.confirmation')</div>
	        <br/>
	        <div class="row">
	            <div class="col-md-4">
	                @include('booking.summary')
	            </div>
                <div class="col-md-4">
                    @include('fragments.auth.sign-up', ['button' => 'view/booking/guest.pay', 'title' => 'view/booking/guest.sign-up', 'identity' => true, 'redirect' => false, 'social' => ['facebook']])
                </div>
                <div class="col-md-4 sign-in">
                    @include('fragments.auth.sign-in', ['button' => 'view/booking/guest.pay', 'title' => 'view/booking/guest.sign-in', 'redirect' => false, 'social' => ['facebook']])
                </div>
	        </div>
            <div class="row">
                <div class="col-md-8 col-md-offset-4">
                    <div>@lang('view/booking/guest.cancel-info')</div>
                    <div>@lang('view/booking/guest.charge')</div>
                </div>
            </div>
            <br/>
	    </div>
	</div>
@endsection