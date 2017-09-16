@if(isset($asked[$state])||isset($received[$state]))
<h2>@lang('view/booking/index.state.'.$state)</h2>
@endif
<fieldset>
    @if(isset($asked[$state]))
        <legend>@lang('view/booking/index.role.traveler')</legend>
        <div class="row">
            @foreach($asked[$state] as $index => $item)
                @if($index != 0 && $index % 2 == 0)
                    <div class="clearfix visible-sm"></div>
                @elseif($index != 0 && $index % 3 == 0)
                    <div class="clearfix visible-md visible-lg"></div>
                @endif
                @include('booking.fragments.experience', ['travel' => $item, 'role' => 'traveler'])
            @endforeach
        </div>
    @endif
    @if(isset($received[$state]))
        <legend>@lang('view/booking/index.role.citizen')</legend>
        <div class="row">
            @foreach($received[$state] as $index => $item)
                @if($index != 0 && $index % 2 == 0)
                    <div class="clearfix visible-sm"></div>
                @elseif($index != 0 && $index % 3 == 0)
                    <div class="clearfix visible-md visible-lg"></div>
                @endif
                @include('booking.fragments.experience', ['travel' => $item, 'role' => 'citizen'])
            @endforeach
        </div>
    @endif
</fieldset>