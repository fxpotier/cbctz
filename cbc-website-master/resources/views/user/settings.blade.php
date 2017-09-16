@extends('layouts.user.profile')

@section('styles')
    <link rel="stylesheet" href="{{asset('css/user.css') }}"/>
@endsection

@section('title')
    @lang('view/user/profile.settings.meta.title')
@endsection

@section('description')
    @lang('view/user/profile.settings.meta.description')
@endsection

@section('body')
<?php $menuProfileItem = 2 ?>
<div class="panel panel-default">
    <div class="panel-body">
        <h1>@lang('view/user/profile.settings.title')</h1>
        <hr/>
        <br/>
        <form  method="post" action="{{action('ProfileController@postSettings')}}" enctype="multipart/form-data">
            <input value="{{csrf_token()}}" type="hidden" name="_token"/>
            @include('fragments.auth.settings')
            <div class="form-group row">
                <div class="col-sm-offset-2 col-md-10">
                    <button type="submit" class="btn btn-primary">@lang('view/user/profile.settings.submit')</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection