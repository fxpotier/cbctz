@extends('layouts.user.profile')

@section('styles')
    <link rel="stylesheet" href="{{asset('css/user.css') }}"/>
@endsection

@section('scripts')
	<script src="{{asset('js/user.js')}}"></script>
@endsection

@section('title')
@lang('view/user/profile.edit.meta.title')
@endsection

@section('description')
@lang('view/user/profile.edit.meta.description')
@endsection

@section('body')
<?php $menuProfileItem = 0 ?>
<div class="panel panel-default">
    <div class="panel-body">
        <h1>@lang('view/user/profile.edit.title')</h1>
        <hr/>
        @include('fragments.alert')
        <br/>
        <div ng-controller="ProfileController" ng-init="languages={{$languages}}; displayLanguages={{$displaylanguages}}; user={{$user}}; displayLanguage={{$userdisplaylanguage}}; mainLanguage={{$mainlanguage}}; spokenLanguages={{$spokenlanguages}}; descriptions={{$descriptions}}">
            <form class="form-horizontal" method="post" action="{{action('ProfileController@postIndex')}}" enctype="multipart/form-data">
                <input value="{{csrf_token()}}" type="hidden" name="_token"/>
                <fieldset>
                    <legend>@lang('fragment/form/identity.legend')</legend>
                    @include('fragments.form.identity')
                </fieldset>
                <fieldset>
                    <legend>@lang('fragment/form/address.legend')</legend>
                    @include('fragments.form.address')
                </fieldset>
                <fieldset>
                    <legend>@lang('fragment/form/language.legend')</legend>
                    @include('fragments.form.language')
                </fieldset>
                <div class="form-group row">
                    <div class="col-sm-offset-2 col-md-10">
                        <button type="submit" class="btn btn-primary">@lang('view/user/profile.edit.submit')</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection