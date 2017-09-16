@extends('layouts.base-no-container')

@section('styles')
    <link rel="stylesheet" href="{{asset('css/booking.css')}}"/>
@endsection

@section('scripts')
    <!-- Facebook Conversion Code for Ajouts au panier -->
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
        window._fbq.push(['track', '6034638376953', {'value':'0.00','currency':'EUR'}]);
    </script>
@endsection

@section('title')
@lang('view/booking/pay.meta.title')
@endsection

@section('description')
@lang('view/booking/pay.meta.description')
@endsection

@section('body')
    <?php $mango = Session::get('mango');
    if(!$mango) $mango = false;
    ?>
    <div class="background-gray">
        <div class="container" ng-init="showAlert={{$mango != false ? 'true': 'false'}}">
            <h1>@lang('view/booking/pay.title')</h1>
            <alert ng-show="showAlert" type="danger" close="showAlert=!showAlert">
                <p class="h4">@lang('utils/mangopay.titles.error')</p>
                @if($mango != false)
                @foreach($mango as $error)
                    {{$error}}<br/>
                @endforeach
                @endif
            </alert>
            <br/>
            <div class="row">
                <div class="col-md-4">
                @include('booking.summary')
                </div>
                <div class="col-md-8">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <form action="{{action('BookingController@postPayment', $slug)}}" method="post" enctype="multipart/form-data">
                                <input value="{{csrf_token()}}" type="hidden" name="_token"/>
                                <input type="hidden" name="people" value="{{ $reservation['people'] }}" />
                                <input type="hidden" name="booking_date" value="{{ $utc }}" />
                                <h2 class="h3">@lang('view/booking/pay.credit-card')</h2>
                                <fieldset>
                                    <legend>@lang('fragment/form/payment.legend')</legend>
                                    @include('fragments.form.payment')
                                </fieldset>
                                <h2 class="h3">@lang('view/booking/pay.check')</h2>
                                <fieldset>
                                    <legend>@lang('fragment/form/identity.legend')</legend>
                                    @include('fragments.form.identity')
                                </fieldset>
                                <fieldset>
                                    <legend>@lang('fragment/form/address.legend')</legend>
                                    @include('fragments.form.address')
                                </fieldset>
                                <div class="row">
                                    <div class="col-md-5 col-md-offset-2">
                                        <button class="btn btn-primary btn-lg" type="submit">@lang('view/booking/pay.submit')</button>
                                    </div>
                                    <div class="col-md-5 text-right">
                                        <img height="45px" src="{{asset('img/app/Mangopay_logo.jpg')}}"/>
                                    </div>
                                </div>
                                <br/>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection