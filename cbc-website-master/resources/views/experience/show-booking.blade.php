<form action="{{action('BookingController@getPay', $experience->slug->first()->name)}}" method="get">
    <input type="hidden" name="_token" value="{{csrf_token()}}"/>
    <div ng-init="traveler_number={{$experience->min_persons}}; fees=2.00; incurred_cost={{$experience->incurred_cost}}; incurred_cost_per_person={{$experience->incurred_cost_per_person}}; tip={{$experience->suggested_tip}}">
        <div class="date-picker">
            <datepicker
                ng-model="date"
                min-date="now"
                show-weeks="false"
                starting-day="1"
                custom-class="getDayClass(date)"
                date-disabled="disabled(date)">
            </datepicker>
        </div>
        <div class="book">
            <br/>
            <br/>
            <div class="row">
                <div class="col-xs-6 h4 offset-td">@lang('view/experience/show.booking.hour')</div>
                <div class="col-xs-6">
                    <div ng-show="hours == null">
                        <timepicker class="timepicker" ng-model="selectedHour" hour-step="1" minute-step="30" show-meridian="false"></timepicker>
                    </div>
                    <div ng-show="hours != null">
                        <select class="form-control select-offset" ng-model="selectedTextHour">
                            <option ng-repeat="hour in hours track by $index" ng-selected="$index == 0" ng-value="hour">${hour | date:'HH:mm'}</option>
                        </select>
                    </div>
                    <input type="hidden" name="date" value="${dateToSend}">
                    <input type="hidden" name="offset" value="${offset}">
                </div>
            </div>
            <hr/>
            <div class="row">
                <div class="col-xs-7 h4">@lang('view/experience/show.booking.traveler')</div>
                <div class="col-xs-5">
                    <label class="sr-only" for="traveler">@lang('view/experience/show.booking.traveler')</label>
                    <input type="number" name="people" class="form-control offset-tr" ng-model="traveler_number" id="traveler" min="{{$experience->min_persons}}" max="{{$experience->max_persons}}">
                </div>
            </div>
            <hr/>
            <div class="row">
                <div class="col-sm-8 h4">@lang('view/experience/show.booking.fees')</div>
                <div class="col-sm-4 h4 text-right">${fees|currency:''}€</div>
            </div>
            @if($experience->incurred_cost + $experience->incurred_cost_per_person>0)
                <br/>
                <div class="row">
                    <div class="col-sm-8 h4">@lang('view/experience/show.booking.costs')</div>
                    <div class="col-sm-4 h4 text-right">{{$experience->incurred_cost + $experience->incurred_cost_per_person}}€</div>
                </div>
                <div class="small text-muted">
                    <div class="row"><div class="col-xs-12">@lang('view/experience/show.booking.included'):</div></div>
                    <ul class="detail">
                        @if($experience->incurred_food_drink_cost>0 || $experience->incurred_food_drink_cost_per_person > 0)
                        <li class="col-xs-6">@lang('view/experience/show.booking.food')</li>
                        <li class="col-xs-6 text-right">
                            {{max($experience->incurred_food_drink_cost, $experience->incurred_food_drink_cost_per_person)}}€
                            @if($experience->incurred_food_drink_cost_per_person > 0)
                                @lang('view/experience/show.booking.per_person')
                            @endif
                        </li>
                        @endif
                        @if($experience->incurred_transportation_cost>0 || $experience->incurred_transportation_cost_per_person>0)
                        <li class="col-xs-6">@lang('view/experience/show.booking.transportation')</li>
                        <li class="col-xs-6 text-right">
                            {{max($experience->incurred_transportation_cost, $experience->incurred_transportation_cost_per_person)}}€
                            @if($experience->incurred_transportation_cost_per_person>0)
                                @lang('view/experience/show.booking.per_person')
                            @endif
                        </li>
                        @endif
                        @if($experience->incurred_ticket_cost>0 || $experience->incurred_ticket_cost_per_person>0)
                        <li class="col-sm-6">@lang('view/experience/show.booking.tickets')</li>
                        <li class="col-sm-6 text-right">
                            {{max($experience->incurred_ticket_cost, $experience->incurred_ticket_cost_per_person)}}€
                            @if($experience->incurred_ticket_cost_per_person>0)
                                @lang('view/experience/show.booking.per_person')
                            @endif
                        </li>
                        @endif
                        @if($experience->incurred_other_cost>0 || $experience->incurred_other_cost_per_person>0)
                        <li class="col-sm-6">@lang('view/experience/show.booking.other')</li>
                        <li class="col-sm-6 text-right">
                            {{max($experience->incurred_other_cost, $experience->incurred_other_cost_per_person)}}€
                            @if($experience->incurred_other_cost_per_person>0)
                                @lang('view/experience/show.booking.per_person')
                            @endif
                        </li>
                        @endif
                    </ul>
                    <div class="row text-primary">&nbsp;&nbsp;&nbsp;&nbsp;* @lang('view/experience/show.booking.included_note')</div>
                </div>
            @endif
            <br/>
            <div class="row">
                <div class="col-sm-8 h4">
                    @if($experience->is_experience_per_person)
                        @lang('view/experience/show.booking.tip_per_person')
                    @else
                        @lang('view/experience/show.booking.tip')
                    @endif
                    @lang('view/experience/show.booking.suggested')
                </div>
                <div class="col-sm-4 h4 text-right">${tip|currency:''}€</div>
            </div>
            <div class="row text-primary small">&nbsp;&nbsp;&nbsp;&nbsp;* @lang('view/experience/show.booking.tip_note')</div>
            <br/>
            <div class="row">
                <div class="col-xs-4 h3">@lang('view/experience/show.booking.total')</div>
                <div class="col-xs-8 h3 text-right" ng-model="price">${(fees + incurred_cost_per_person)*traveler_number+incurred_cost|currency:''}€ (+Tip)</div>
            </div>
            <br/>
            <div class="text-center">
                <button class="btn btn-primary btn-lg" type="submit">@lang('view/experience/show.booking.book')</button>
            </div>
            <br/>
        </div>
    </div>
</form>