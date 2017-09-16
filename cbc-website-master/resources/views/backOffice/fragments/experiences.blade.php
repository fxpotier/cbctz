
@foreach($experiences as $index => $experience)
    @if($index != 0 && $index % 2 == 0)
        <div class="clearfix visible-sm"></div>
    @endif
    @if($index != 0 && $index % 3 == 0)
        <div class="clearfix visible-md visible-lg"></div>
    @endif
    <div class="col-md-4 col-sm-6">
        <div class="experience panel panel-default">
            <a class="experience-link" href="{{action('ExperienceController@getShow', $experience->slugName)}}">
                @include('backOffice.fragments.experience')
            </a>
        </div>
    </div>
@endforeach
