@extends('layouts.home')

@section('styles')
    <link rel="stylesheet" href="{{asset('css/welcome.css') }}"/>
@endsection

@section('scripts')
    <script type="text/javascript" src="{{asset('js/welcome.js')}}"></script>
    <!-- Facebook Conversion Code for Prospects - François-Xavier Potier -->
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
        window._fbq.push(['track', '6034638390353', {'value':'0.00','currency':'EUR'}]);
    </script>
@endsection

@section('title')
@lang('view/welcome.meta.title')
@endsection

@section('description')
@lang('view/welcome.meta.description')
@endsection

@section('body')
    @include('welcome.header')
    @include('welcome.experiences')
    @include('welcome.instructions')
    @include('welcome.community')
    @include('welcome.map')
    @include('welcome.partners')
@endsection