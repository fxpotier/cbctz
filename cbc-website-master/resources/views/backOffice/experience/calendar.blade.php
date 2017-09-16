@extends('layouts.backOffice.base')

@section('styles')
    <link rel="stylesheet" href="{{asset('css/user.css') }}"/>
    <link rel="stylesheet" href="{{asset('css/experience.css') }}"/>
@endsection

@section('scripts')
    <script type="text/javascript" src="{{asset('js/adminValue.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/experience.js')}}"></script>
	<script type="text/javascript" src="{{asset('js/user.js')}}"></script>
@endsection

@section('body')
    <div class="experience create background-gray" ng-controller="CalendarController">
        <div class="container calendar" ng-init="slug='{{$slug}}'">
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