<div class="panel panel-primary experience-summary">
    <div class="panel-heading cover" style="background-image: url('{{asset($experience->thumbnailPicture ? $experience->thumbnailPicture->source : 'img/app/experiences/no_thumbnail.jpg')}}')">
    </div>
    <div class="panel-body">
        <h2 class="h3">{{$experience->description->title}}</h2>
        <p class="h2"><small>@lang('view/booking/summary.with') {{$experience->citizen->firstname}}<br/>@lang('view/booking/summary.in') {{$experience->meetingPoint->city}}</small></p>
        <hr/>
        <div class="row">
            <div class="col-xs-6">{{$reservation['people']}} @choice('view/booking/summary.person', $reservation['people'])</div>
            <div class="col-xs-6">{{$reservation['date']->format('d/m/Y H:i')}}</div>
        </div>
        <hr/>
        <div class="text-center h3">
            <p class="text-muted">
            {{number_format((2 + $experience->incurred_cost_per_person)*$reservation['people']+$experience->incurred_cost,2)}} €<br/>+ @lang('view/booking/summary.tip')
            </p>
        </div>
        <br/>
        <a href="{{action('ExperienceController@getShow', $slug)}}" class="btn btn-info btn-lg btn-block">@lang('view/booking/summary.change')</a>
        <br/>
    </div>
</div>