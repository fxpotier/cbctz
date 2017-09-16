<div class="form-group row has-feedback {{$errors->first('first-city') ? 'has-error' : ''}}">
    <label for="first-city" class="col-md-2 control-label">@lang('view/experience/create.place.input.first-city')</label>
    <div class="col-md-10">
        <input name="first-city" type="text" class="form-control" id="first-city" placeholder="@lang('view/experience/create.place.input.first-city')" required value="{{$experience->area->address->city or Session::get('inputs')['first-city']}}">
        <p class="help-block">@lang('view/experience/create.place.help.first-city')</p>
        <p class="help-block text-error">@lang($errors->first('first-city'))</p>
    </div>
</div>

<div class="form-group row  has-feedback {{$errors->first('second-city') ? 'has-error' : ''}}" ng-init="cities = {{isset(Session::get('inputs')['cities']) ? json_encode(Session::get('inputs')['cities']) : '[]'}}">
    <label for="second-city" class="col-md-2 control-label">@lang('view/experience/create.place.input.second-city')</label>
    <div class="col-md-10">
        <tags-input id="cities" add-on-space="true" placeholder="@lang('view/experience/create.place.input.second-city-add')" ng-model="cities" display-property="name" replace-spaces-with-dashes="false" min-length="1">
            {{--<auto-complete debounce-delay="250" min-length="0" source="getCities($query)" min-length="0" max-results-to-show="5"></auto-complete>--}}
        </tags-input>
        <input name="cities[]" ng-repeat="city in cities" type="hidden" ng-value="city.name||city"/>
        <p class="help-block">@lang('view/experience/create.place.help.second-city')</p>
        <p class="help-block text-error">@lang($errors->first('second-city'))</p>
    </div>
</div>

<div class="form-group row  has-feedback {{$errors->first('country') ? 'has-error' : ''}}">
    <label for="country" class="col-md-2 control-label">@lang('view/experience/create.place.input.country')</label>
    <div class="col-md-10">
        <input name="country" type="text" class="form-control" id="country" placeholder="@lang('view/experience/create.place.input.country')" required value="{{$experience->area->address->country or Session::get('inputs')['country']}}">
        <p class="help-block">@lang('view/experience/create.place.help.country')</p>
        <p class="help-block text-error">@lang($errors->first('country'))</p>
    </div>
</div>


<div class="form-group row  has-feedback {{$errors->first('distance') ? 'has-error' : ''}}">
    <label for="distance" class="col-md-2 control-label">@lang('view/experience/create.place.input.distance')</label>
    <div class="col-md-10">
        <div class="input-group">
            <input name="distance" type="number" step="0.1" class="form-control" id="distance" placeholder="@lang('view/experience/create.place.input.distance')" required value="{{$experience->area->range or Session::get('inputs')['distance']}}">
            <div class="input-group-addon">&nbsp;Km&nbsp;</div>
        </div>
        <p class="help-block">@lang('view/experience/create.place.help.distance')</p>
        <p class="help-block text-error">@lang($errors->first('distance'))</p>
    </div>
</div>