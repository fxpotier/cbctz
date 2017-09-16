@extends('layouts.base-no-container')

@section('scripts')
    <script type="text/javascript" src="{{asset('js/userValue.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/experience.js')}}"></script>
    <!-- Facebook Conversion Code for Affichages Expérience -->
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
        window._fbq.push(['track', '6034638490553', {'value':'0.00','currency':'EUR'}]);
    </script>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{asset('css/experience.css')}}"/>
@endsection

@section('title')
@lang('view/experience/show.meta.title', ['title' => $experience->description ? $experience->description->title : ''])
@endsection

@section('description')
@lang('view/experience/show.meta.description', ['content' => $experience->description ? $experience->description->content : ''])
@endsection

@section('body')
<div class="experience show">
    <div class="header" style="background-image: url({{asset($experience->coverPicture ? $experience->coverPicture->source : 'img/app/experiences/no_cover.jpg')}})"></div>
    <div class="container-fluid" ng-controller="ShowController" ng-init="slug='{{$slug}}'">
        <div class="row">
            <div class="content-left">
                <div class="profile-img profile-offset">
                    <div class="img img-circle" style="background-image: url({{asset($experience->citizen->profilePicture ? $experience->citizen->profilePicture->source : 'img/app/users/no_profile.png')}})"></div>
                </div>
                <div class="details">
                    <h1>{{$experience->description->title or ''}}</h1>
                    <div class="h3"><span class="text-muted">
                        @lang('view/experience/show.details.by') {{$experience->citizen->firstname}}
                        <?php $years =  Carbon::now()->diffInYears($experience->citizen->birthdate) ?>
                        @if($years >= 18 && $years <= 125)
                        ({{$years}} @lang('view/profile/show.details.years'))</span>
                        @endif
                    </div>
                    <span class="h4">
                        @include('fragments.rate', ['rate_avg' => $experience->feedbackStats ? $experience->feedbackStats->rate_average : null, 'rate_count' => $experience->feedbackStats ? $experience->feedbackStats->rate_count : null])
                        @if($experience->feedbackStats)
                            <small>({{$experience->feedbackStats->rate_count}} rates)</small>&nbsp;&nbsp;&nbsp;
                        @endif
                    </span>
                    @foreach($experience->languages as $language)
                        @if(isset($language->alias) && isset($experience->slugByAlias[$language->alias]))
                            <a href="{{action('ExperienceController@getShow', array($experience->slugByAlias[$language->alias], $language->alias))}}">
                                <img src="{{asset('img/app/flags/' . $language->alias . '.png')}}"/>
                            </a>
                        @endif
                    @endforeach
                </div>
                <br/>
                <br/>
                <br/>
                <p class="text-justify description">
                    {{$experience->description->content or ''}}
                </p>
                <br/>
                <carousel class="carousel" interval="5000">
                    @foreach($experience->pictures as $picture)
                        @if($picture->album == 'description')
                            <slide>
                                <img ng-src="{{asset($picture->source)}}" style="margin:auto;">
                            </slide>
                        @endif
                    @endforeach
                </carousel>
                <br/>
                @if($experience->tags->count())
                <h3 class="h4">@lang('view/experience/show.details.about')</h3>
                <br/>
                @endif
                <div class="tags">
                    @foreach($experience->tags as $tag)
                        <a class="label label-info" target="_blank" href="{{action('SearchController@getSearch', $tag->slug)}}"><em class="h4">{{$tag->name}}</em></a>
                    @endforeach
                </div>
                <br/>
                <div class="panel panel-default">
                    <div class="panel-body">
                        @if($experience->feedbacks->count())
                            <div class="text-center h3">@lang('view/experience/show.details.comments')</div>
                        @else
                            <br/>
                            <div class="text-center h3"><b>@lang('view/experience/show.details.comments-empty')</b></div>
                            <br/>
                        @endif
                        @foreach($experience->feedbacks as $feedback)
                                <div class="img-comment img-circle" style="background-image: url({{asset($feedback->author->profilePicture ? $feedback->author->profilePicture->source : 'img/app/users/no_profile.png')}})"></div>
                                <div class="text-comment">
                                    <div class="h3 text-default">
                                        {{$feedback->author->firstname}}&nbsp;&nbsp;&nbsp;
                                            @include('fragments.rate', ['rate_avg' => $feedback->value, 'rate_count' => 1])
                                    </div>
                                    <p class="text-justify">{{$feedback->content}}</p>
                                </div>
                                <hr/>
                        @endforeach
                    </div>
                </div>
                <br/>
                <?php
                    $time = Carbon::createFromTimeStamp($experience->duration * 60);
                    $days = $time->diffInDays(Carbon::createFromTimeStamp(0))
                ?>
                <div class="header" style="background-image: url({{asset($experience->coverPicture ? $experience->coverPicture->source : 'img/app/experiences/no_cover.jpg')}})">
                    <div class="darken background-inverse text-center">
                        <br/>
                        <br/>
                        <div class="h3"><b>@lang('view/experience/show.details.information')</b></div>
                        <br/>
                        <div class="row">
                            <div class="col-xs-6">
                                <p class="h3 text-uppercase">@lang('view/experience/show.details.can-be')</p>
                                <img class="about-img" src="{{asset('img/app/experiences/traveler.svg')}}"/>
                                <p class="h4">{{$experience->min_persons}} @choice('view/experience/show.details.traveler', $experience->min_persons) @lang('view/experience/show.details.minimum')</p>
                                <p class="h4">{{$experience->max_persons}} @choice('view/experience/show.details.traveler', $experience->max_persons) @lang('view/experience/show.details.maximum')</p>
                            </div>
                            <div class="col-xs-6">
                                <p class="h3 text-uppercase">@lang('view/experience/show.details.duration')</p>
                                <img class="about-img" src="{{asset('img/app/experiences/time.svg')}}"/>
                                <p class="h4">
                                    @if($days)
                                    {{$days}} @lang('fragment/app/experiences.days')
                                    @endif
                                    {{$time->format('h\hi')}}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <br/>
                <br/>
                <div class="text-center h3"><b>@lang('view/experience/show.details.who')</b></div>
                <br/>
                <div class="profile-img">
                    <div class="img img-circle" style="background-image: url({{asset($experience->citizen->profilePicture ? $experience->citizen->profilePicture->source : 'img/app/users/no_profile.png')}})"></div>
                </div>
                <div class="details">
                    <div class="h2">{{$experience->citizen->firstname}}</div>
                    <div class="h3">
                        <span class="text-muted">
                            @if($years >= 18 && $years <= 125)
                                {{$years}} @lang('view/profile/show.details.years')
                            @endif
                        </span>
                    </div>
                    <div class="h4">
                        @include('fragments.rate', ['rate_avg' => $experience->citizen->feedbackStats ? $experience->citizen->feedbackStats->rate_average : null, 'rate_count' =>  $experience->citizen->feedbackStats ? $experience->citizen->feedbackStats->rate_count : null])&nbsp;
                        @if($experience->citizen->feedbackStats)
                            <small>({{$experience->citizen->feedbackStats->rate_count}} rates)</small>
                        @endif
                    </div>
                    <div>
                        @foreach($experience->citizen->languages as $language)
                            <a target="_blank" href="{{action('ProfileController@getShow', [$experience->citizen->slug[0]->name,$language->alias])}}">
                                <img src="{{asset('img/app/flags/' . $language->alias . '.png')}}"/>
                            </a>
                        @endforeach
                    </div>
                </div>
                <br/>
                <br/>
                <p class="text-justify description">
                    {{$experience->citizen->description->content or ''}}
                </p>
                <br/>
                <div>
                    <b><a target="_blank" href="{{action('ProfileController@getShow', $experience->citizen->slug[0]->name)}}" class="text-uppercase"><span class="glyphicon glyphicon-chevron-right"></span>&nbsp;@lang('view/experience/show.citizen.profile')</a></b>
                </div>
                <br/>
                <div ng-init="zoom=zoomFromRadius({{$experience->area->range * 1000}})">
                    <ui-gmap-google-map
                            center='{latitude:{{$experience->area->address->latitude}}, longitude:{{$experience->area->address->longitude}}}'
                            zoom='zoom'
                            options="{scrollwheel:false}">
                        <ui-gmap-marker
                            idKey=1
                            coords='{latitude:{{$experience->meetingPoint->latitude}}, longitude:{{$experience->meetingPoint->longitude}}}'>
                        </ui-gmap-marker>
                        <ui-gmap-circle
                            center="{latitude:{{$experience->area->address->latitude}}, longitude:{{$experience->area->address->longitude}}}"
                            radius="{{$experience->area->range * 1000}}"
                            stroke="{color: '#4cc4d1', weight: 2, opacity: 1}"
                            fill="{color: '#4cc4d1', opacity: 0.2}"></ui-gmap-circle>
                    </ui-gmap-google-map>
                </div>
                <div class="row" style="padding-top: 15px">
                    <div class="col-xs-1">
                        <span class="meeting-point-marker fa fa-map-marker"></span>
                    </div>
                    <div class="col-xs-11">
                        <div class="h3 text-default">
                            <div><b>@lang('view/experience/show.location.meet'): {{$experience->meetingPoint->street}} - {{$experience->meetingPoint->zipcode}}</b></div>
                            <div><b>{{$experience->meetingPoint->city}}, {{$experience->meetingPoint->country}}</b></div>
                            <div class="text-uppercase"><b>@lang('view/experience/show.location.see')</b></div>
                        </div>
                    </div>
                </div>
                <br/>
            </div>
            <div class="content-right">
                @include('experience/show-booking')
            </div>
        </div>
    </div>
</div>
@endsection
