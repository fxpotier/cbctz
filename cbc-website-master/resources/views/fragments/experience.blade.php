<div class="panel-heading" style="background-image: url({{asset($experience->thumbnailPicture ? $experience->thumbnailPicture->source : 'img/app/experiences/no_thumbnail.jpg')}})">
    <div class="grade-area">
        <div class="row">
            <div class="col-xs-6">{{number_format ($experience->incurred_cost + $experience->suggested_tip, 2)}}€</div>
            <div class="col-xs-6 text-right">
            @include('fragments/rate', ["rate_count" => $experience->feedbackStats ? $experience->feedbackStats->rate_count : null, "rate_avg" => $experience->feedbackStats ? $experience->feedbackStats->rate_average : null])
            </div>
        </div>
    </div>
</div>
<?php
    $time = Carbon::createFromTimeStamp($experience->duration * 60);
    $days = $time->diffInDays(Carbon::createFromTimeStamp(0))
?>
<div class="panel-body">
    <div class="row text-content">
        <div class="col-xs-6">
            <h2 class="h5"><b>{{$experience->description->title}}</b></h2>
            <p class="small">@lang('fragment/app/experiences.with') {{$experience->citizen->firstname}} {{$experience->citizen->lastname[0]}}.</p>
        </div>
        <div class="col-xs-6 text-right">
            <p class="text-uppercase"><span class="fa fa-map-marker"></span>&nbsp;&nbsp;{{$experience->area->address->city}}</p>
            <p><span class="fa fa-clock-o"></span>&nbsp;&nbsp;
                @if($days)
                {{$days}} @lang('fragment/app/experiences.days')
                @endif
                {{$time->format('h:i')}}
            </p>
        </div>
    </div>
    <div class="text-right">
        @foreach($experience->languages as $language)
            @if(isset($language->alias) && isset($experience->slugByAlias[$language->alias]))
                <a target="_blank" href="{{action('ExperienceController@getShow', array($experience->slugByAlias[$language->alias], $language->alias))}}">
                    <img src="{{asset('img/app/flags/' . $language->alias . '.png')}}"/>
                </a>
            @endif
        @endforeach
    </div>
    <div class="tags">
        @foreach($experience->tags as $tag)
            <a class="label label-info" target="_blank" href="{{action('SearchController@getSearch', $tag->slug)}}"><em>{{$tag->name}}</em></a>
        @endforeach
    </div>
</div>
