@extends('layouts.backOffice.base')

@section('scripts')
    <script type="text/javascript" src="{{asset('js/experience.js')}}"></script>
@endsection

@section('title')
@lang('view/back-office/experience.meta.title')
@endsection

@section('description')
@lang('view/back-office/experience.meta.description')
@endsection

@section('body')
    <div class="container" ng-controller="CreateController" ng-init="url='experience/'">
        <br/>
        <h1>@choice('view/back-office/experience.manage', 2)</h1>
        <hr/>
        @foreach($experiences as $state => $experiencesByState)
            <h2>@lang('fragment/app/experiences.states.'.$state)</h2>
            <div class="row">
                @include('backOffice.fragments.experiences', ['experiences' => $experiencesByState, 'state' => $state])
            </div>
            <hr/>
        @endforeach
        <br/>
        <br/>
    </div>
    <script type="text/ng-template" id="deleteModal.html">
        <div class="modal-header">
            <h3 class="modal-title">@lang('view/experience/create.modal.title')</h3>
        </div>
        <div class="modal-body">
            @lang('view/experience/create.modal.content')
        </div>
        <div class="modal-footer">
            <button class="btn btn-danger" ng-click="validate()">@lang('view/experience/create.modal.validate')</button>
            <button class="btn btn-primary" ng-click="cancel()">@lang('view/experience/create.modal.cancel')</button>
        </div>
    </script>
@endsection