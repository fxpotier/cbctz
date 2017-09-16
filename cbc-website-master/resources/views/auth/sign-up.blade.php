@extends('layouts.base-no-container')

@section('scripts')
	<script type="text/javascript" src="{{asset('js/auth.js')}}"></script>
    <!-- Facebook Conversion Code for Inscriptions -->
    <script>(function() {
            var _fbq = window._fbq || (window._fbq = []);
            if (!_fbq.loaded) {
                var fbds = document.createElement('script');
                fbds.async = true;
                fbds.src = '//connect.facebook.net/en_US/fbds.js';
                var s = document.getElementsByTagName('script')[0];
                s.parentNode.insertBefore(fbds, s);
                _fbq.loaded = true;
            }
        })();
        window._fbq = window._fbq || [];
        window._fbq.push(['track', '6034638460753', {'value':'0.00','currency':'EUR'}]);
    </script>
@endsection

@section('title')
    @lang('fragment/auth/signup.meta.title')
@endsection

@section('description')
    @lang('fragment/auth/signup.meta.description')
@endsection

@section('body')
	<div class="background-gray">
	    <div class="container" ng-controller="signup" ng-init="csrf_token='{{csrf_token()}}'">
	        <br/>
	        <br/>
	        <div class="col-lg-8 col-lg-offset-2 col-md-8 col-md-offset-2">
                @include('fragments.auth.sign-up', ['name' => 'City by citizen', 'identity' => true, 'social' => ['facebook']])
                <br/>
	        </div>
	    </div>
	</div>
@endsection