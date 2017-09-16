@extends('layouts.base-no-container')

@section('styles')
<link rel="stylesheet" href="{{asset('css/profile.css') }}"/>
@endsection

@section('title')
@lang('view/profile/show.meta.title', ['name' => $user->firstname])
@endsection

@section('description')
@lang('view/profile/show.meta.description', ['content' => isset($user->description->content) ? $user->description->content : trans('view/profile/show.meta.title', ['name' => $user->firstname])])
@endsection

@section('body')
<div class="profile show">
    <div class="header" style="background-image: url({{asset($coverpicture)}})"></div>
    <div class="container">
        <div class="profile-img">
            <div class="img img-circle" style="background-image: url({{asset($profilepicture)}})"></div>
        </div>
        <div class="details left">
            <h1>{{$user->firstname}}</h1>
            <span class="h4">
                @include('fragments.rate', ['rate_avg' => $user->feedbackStats ? $user->feedbackStats->rate_average : null, 'rate_count' => $user->feedbackStats ? $user->feedbackStats->rate_count : null])&nbsp;
                @if($user->feedbackStats)
                    <small>({{$user->feedbackStats->rate_count}} rates)</small>
                @endif
            </span>
            <?php $age = Carbon::now()->diffInYears($user->birthdate) ?>
            @if($age > 18 && $age < 125)
            <div class="h3"><span class="text-muted">{{$age}} @lang('view/profile/show.details.years')</span></div>
            @endif
        </div>
        <div class="details right">
            <div class="h3">
                <span class="text-muted">@lang('view/profile/show.details.in')</span>
            </div>
            <div class="h3">
                <span class="text-muted">
                    <?php $count=count($user->experiences) ?>
                    @foreach($cities as $key=>$city)
                        {{$city}}@if($count-1!=$key),&nbsp;@endif
                    @endforeach
                </span>
            </div>
            <div>
                @foreach($user->languages as $language)
                    <a href="{{action('ProfileController@getShow', [$user->slug[0]->name,$language->alias])}}">
                        <img src="{{asset('img/app/flags/' . $language->alias . '.png')}}"/>
                    </a>
                @endforeach
            </div>
        </div>
        <br/>
        <br/>
    </div>
    <div class="container">
        <p class="text-justify description">
            {{$user->description->content or ''}}
        </p>
        <br/>
        <div class="panel panel-default">
            <div class="panel-body">
                @if($user->feedbacksReceived->count())
                    <div class="text-center h2">@lang('view/profile/show.comments')</div>
                    @foreach($user->feedbacksReceived as $feedback)
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
                @else
                    <br/>
                    <div class="text-center h2">@lang('view/profile/show.comments-empty')</div>
                    <br/>
                @endif
                @if($user->travelsAsCitizen)
                    @foreach($user->travelsAsCitizen as $travel)
                        @if($travel->feedback_state == 1 || $travel->feedback_state == 3)
                        <div class="img-comment img-circle" style="background-image: url({{asset($travel->traveler->profilePicture ? $travel->traveler->profilePicture->source : 'img/app/users/no_profile.png')}})"></div>
                        <div class="text-comment">
                            <div class="h3 text-default">
                                {{$travel->traveler->firstname}}&nbsp;&nbsp;&nbsp;
                                @if($travel->feedback)
                                    @include('fragments.rate', ['rate_avg' => $travel->feedback->value, 'rate_count' => 1])
                                @endif
                            </div>
                            <p class="text-justify">{{$travel->feedback->content or ''}}</p>
                        </div>
                        <hr/>
                        @endif
                    @endforeach
                @endif
            </div>
        </div>
        <br/>
        @if(count($user->experiences))
        <h1 class="text-center h2">@lang('view/profile/show.experiences')</h1>
        <br/>
        <div class="row">
            @include('fragments.experiences', ['experiences'=> $user->experiences])
        </div>
        @endif

        <?php /*
        @if($user->articles)
        <h1 class="text-center">@lang('view/profile/show.articles')</h1>
        <br/>
        @endif */ ?>

    </div>
</div>
@endsection