@extends('layouts.user.full-no-container')

@section('styles')
    <link rel="stylesheet" href="{{asset('css/user.css') }}"/>
    <link rel="stylesheet" href="{{asset('css/experience.css') }}"/>
@endsection

@section('scripts')
    <script type="text/javascript" src="{{asset('js/userValue.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/experience.js')}}"></script>
	<script type="text/javascript" src="{{asset('js/user.js')}}"></script>
@endsection

@section('user-nav')
    @include('fragments.user.user-nav', ["menuItem" => 1])
@endsection

@section('title')
@lang('view/experience/calendar.meta.title')
@endsection

@section('description')
@lang('view/experience/calendar.meta.description')
@endsection

@section('body')
    <div class="experience create background-gray" ng-controller="CalendarController" ng-init="slug='{{$slug}}'">
        <div class="container calendar">
            <div class="panel panel-default panel-create">
                <div class="panel-body">
                    <h1>@lang('view/experience/calendar.title')</h1>
                    <hr/>
                    @include('experience/fragments/form-calendar')
                </div>
            </div>
        </div>
    </div>
@endsection
