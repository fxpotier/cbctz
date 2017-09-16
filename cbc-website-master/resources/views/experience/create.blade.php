@extends('layouts.user.full-no-container')

@section('styles')
    <link rel="stylesheet" href="{{asset('css/user.css') }}"/>
    <link rel="stylesheet" href="{{asset('css/experience.css') }}"/>
@endsection

@section('scripts')
    <script type="text/javascript" src="{{asset('js/experience.js')}}"></script>
	<script src="{{asset('js/user.js')}}"></script>
    <!-- Facebook Conversion Code for Création expérience -->
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
        window._fbq.push(['track', '6034638440953', {'value':'0.00','currency':'EUR'}]);
    </script>
@endsection

@section('user-nav')
    @include('fragments.user.user-nav', ["menuItem" => 1])
@endsection

@section('title')
@lang('view/experience/create.meta.title')
@endsection

@section('description')
@lang('view/experience/create.meta.description')
@endsection

@section('body')
    <div class="experience create background-gray" ng-controller="CreateController">
        <div class="container" ng-init="showAlert={{$message != null ? 'true': 'false'}}">
            <alert ng-show="showAlert" type="success" close="showAlert=!showAlert">
                <p class="h4">@lang('view/experience/create.message.title')</p>
                @lang('view/experience/create.message.banking-missing', ['link' => action('ProfileController@getBanking'), 'message' => $message]);
            </alert>
            @foreach($experiences as $state => $experiencesByState)
                <h2>@lang('fragment/app/experiences.states.'.$state)</h2>
                <div class="row">
                    @include('experience.fragments.create.experiences', ['experiences' => $experiencesByState, 'state' => $state])
                </div>
            @endforeach
            <div class="row">
                <div class="col-md-4 col-sm-6">
                    <div class="experience panel panel-default">
                        <a class="experience-link" href="" ng-click="add=!add">
                            <div class="panel-body add-container">
                                <div class="add text-center">+</div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div ng-show="add" class="panel panel-default panel-create" ng-show="create">
                <div class="panel-body">
                    <p class="h2">@lang('view/experience/create.title') !</p>
                    <hr/>
                    <br/>
                    <form action="{{action('ExperienceController@postIndex')}}" method="post">
                        @include('experience.fragments.form-main')
                        <div class="row">
                            <div class="text-center">
                                <button type="submit" class="btn btn-danger btn-lg"><b>@lang('view/experience/create.submit')</b></button>
                            </div>
                        </div>
                    </form>
                </div>
                <br/>
            </div>
            <br/>
        </div>
      <?php /*  <div class="create-background background-inverse" ng-if="!add">
            <div class="container text-center">
                <br/><br/><br/>
                <div class="h2"><b class="text-uppercase">lang('view/experience/create.tips')</b></div>
                <br/><br/>
                <button type="button" class="btn btn-primary btn-lg text-uppercase">lang('view/experience/create.here')</button>
            </div>
        </div>*/
    ?>
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
