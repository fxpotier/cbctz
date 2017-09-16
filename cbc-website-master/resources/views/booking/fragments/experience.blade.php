<div class="col-md-4 col-sm-6">
    <div class="experience panel panel-default">
        @include('fragments.experience', ['experience' => $travel->experience])
        <div class="panel-footer">
            <div class="details">
                <div class="row">
                    <div class="col-xs-6">{{$travel->persons}} @choice('view/booking/index.people', $travel->persons)</div>
                    <div class="col-xs-6 text-right">{{Carbon::parse($travel->event->date)->format('d/m/y - H:i')}}</div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        @if($role == 'citizen' && $state == 'asked')
                            <br/>
                            @lang('view/booking/index.asked_by') <a href="{{action('ProfileController@getShow', $travel->traveler->slug[0]->name)}}" target="_blank" class="text-capitalize text-link">{{$travel->traveler->firstname}} {{$travel->traveler->lastname[0]}}.</a>
                        @elseif($role == 'traveler' && $state == 'booked')
                            <br/>
                            @lang('view/booking/index.citizen'):
                            <ul>
                                <li><a href="{{action('ProfileController@getShow', $travel->citizen->slug[0]->name)}}" target="_blank" class="text-capitalize text-link">{{$travel->citizen->firstname}} {{$travel->citizen->lastname[0]}}.</a></li>
                                <li>{{$travel->citizen->account->mail}}</li>
                                <li>{{$travel->citizen->phone}}</li>
                            </ul>
                        @elseif($role == 'citizen' && $state == 'booked')
                            <br/>
                            @lang('view/booking/index.traveler'):
                            <ul>
                                <li><a href="{{action('ProfileController@getShow', $travel->traveler->slug[0]->name)}}" target="_blank" class="text-capitalize text-link">{{$travel->traveler->firstname}} {{$travel->traveler->lastname[0]}}.</a></li>
                                <li>{{$travel->traveler->account->mail}}</li>
                                <li>{{$travel->traveler->phone}}</li>
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">
                @if($state == 'asked' && $role == 'citizen')
                    <div class="col-xs-6 thin-padding-right">
                        <button type="button" class="btn btn-primary btn-block" ng-click="changeState('{{$travel->experience->description->title}}', '{{$travel->event->date}}', '{{$travel->persons}}', {{$travel->id}}, 'booked', '{{$role}}')">@lang('view/booking/index.action.accept')</button>
                    </div>
                    <div class="col-xs-6 thin-padding-left">
                        <button type="button" class="btn btn-danger btn-block" ng-click="changeState('{{$travel->experience->description->title}}', '{{$travel->event->date}}', '{{$travel->persons}}', {{$travel->id}}, 'denied', '{{$role}}')">@lang('view/booking/index.action.decline')</button>
                    </div>
                @elseif($state == 'asked' && $role == 'traveler' || $state == 'booked')
                    <div class="col-xs-12">
                        <button type="button" class="btn btn-danger btn-block" ng-click="changeState('{{$travel->experience->description->title}}', '{{$travel->event->date}}', '{{$travel->persons}}', {{$travel->id}}, 'canceled', '{{$role}}')">@lang('view/booking/index.action.cancel')</button>
                    </div>
                @elseif($state == 'done')
                    @if($role == 'traveler' && ($travel->feedback_state == 0 || $travel->feedback_state == 2) || $role == 'citizen' && ($travel->feedback_state == 0 || $travel->feedback_state == 1))
                    <div class="col-xs-6 thin-padding-right">
                        <button type="button" class="btn btn-primary btn-block" ng-click="feedback({{$travel->id}}, '{{$role}}')">@lang('view/booking/index.action.comment')</button>
                    </div>
                    @else
                    <div class="col-xs-6 thin-padding-right"></div>
                    @endif
                    @if($role == 'traveler' && ($travel->signal == 0 || $travel->signal == 2) || $role == 'citizen' && ($travel->signal == 0 || $travel->signal == 1))
                    <div class="col-xs-6 thin-padding-left">
                        <button type="button" class="btn btn-danger btn-block" ng-click="signal({{$travel->id}}, '{{$role}}')">@lang('view/booking/index.action.signal')</button>
                    </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>