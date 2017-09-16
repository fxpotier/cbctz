@extends('layouts.user.full-no-container')

@section('styles')
    <link rel="stylesheet" href="{{asset('css/user.css') }}"/>
    <link rel="stylesheet" href="{{asset('css/experience.css') }}"/>
@endsection

@section('scripts')
    <script type="text/javascript" src="{{asset('js/experience.js')}}"></script>
	<script src="{{asset('js/user.js')}}"></script>
@endsection

@section('user-nav')
    @include('fragments.user.user-nav', ["menuItem" => 1])
@endsection

@section('title')
@lang('view/experience/edit.meta.title')
@endsection

@section('description')
@lang('view/experience/edit.meta.description')
@endsection

@section('body')
    <div class="container">
        <br/>
        <div class="panel panel-default panel-create">
            <div class="panel-body">
                <p class="h2">@lang('view/experience/edit.title') !</p>
                <hr/>
                <br/>
                <form action="{{action('ExperienceController@postEdit', $slug)}}" method="post">
                    @include('experience.fragments.form-main')
                    <div class="row">
                        <div class="text-center">
                            <button type="submit" class="btn btn-danger btn-lg"><b>@lang('view/experience/edit.submit')</b></button>
                        </div>
                    </div>
                </form>
            </div>
            <br/>
        </div>
        <br/>
    </div>
@endsection