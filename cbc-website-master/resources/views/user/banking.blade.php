@extends('layouts.user.profile')

@section('styles')
    <link rel="stylesheet" href="{{asset('css/user.css') }}"/>
@endsection

@section('title')
    @lang('view/user/profile.banking.meta.title')
@endsection

@section('description')
    @lang('view/user/profile.banking.meta.description')
@endsection

@section('body')
<?php $menuProfileItem = 3;
$mango = Session::get('mango');
if(!$mango) $mango = false;
$success = Session::get('success');
if(!$success) $success = false;
?>
<div class="panel panel-default">
    <div class="panel-body" ng-init="showAlert={{$mango != false ? 'true': 'false'}}; showSuccess={{$success != false ? 'true': 'false'}};">
        <h1>@lang('view/user/profile.banking.title')</h1>
        <alert ng-show="showAlert" type="danger" close="showAlert=!showAlert">
            <p class="h4">@lang('utils/mangopay.titles.error')</p>
            @if(!empty($mango))
                @foreach($mango as $error)
                    {{$error}}<br/>
                @endforeach
            @endif
        </alert>
        <alert ng-show="showSuccess" type="success" close="showSuccess=!showSuccess">
            <p class="h4">@lang('utils/mangopay.titles.editsuccess')</p>
            @if(!empty($success))
                @foreach($success as $message)
                    {{$message}}<br/>
                @endforeach
            @endif
        </alert>
        @if(isset($user->payment) && !is_null($user->payment->wallet_id) && !is_null($user->payment->bank_id))
        <p class="">
            <span aria-hidden="true" class="glyphicon glyphicon-ok text-green"></span>&nbsp;@lang('view/user/profile.banking.set')
        </p>
        @endif
        <hr/>
        <br/>
        <form  method="post" action="{{action('ProfileController@postBanking')}}" enctype="multipart/form-data">
            <input value="{{csrf_token()}}" type="hidden" name="_token"/>
            @include('fragments.form.rib')
            <div class="form-group row">
                <div class="col-sm-offset-2 col-md-10">
                    <button type="submit" class="btn btn-primary">@lang('view/user/profile.banking.submit')</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
