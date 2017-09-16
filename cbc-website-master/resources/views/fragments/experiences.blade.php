@foreach($experiences as $index => $experience)
    @if($index != 0 && $index % 3 == 0)
        <div class="clearfix visible-md visible-lg"></div>
    @endif
    @if($index != 0 && $index % 2 == 0)
        <div class="clearfix visible-sm"></div>
    @endif
    <div class="col-md-4 col-sm-6">
        <div class="experience panel panel-default">
            <a class="experience-link" target="_blank" href="{{action('ExperienceController@getShow', $experience->slugName)}}">
                @include('fragments.experience')
            </a>
        </div>
    </div>
@endforeach
