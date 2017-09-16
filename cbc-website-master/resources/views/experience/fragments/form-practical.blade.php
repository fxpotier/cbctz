<div class="form-group row has-feedback {{$errors->first('min_persons') ? 'has-error' : ''}}">
    <label for="min-travelers" class="col-md-2 control-label">@lang('view/experience/create.practical.input.min-travelers')</label>
    <div class="col-md-10">
        <input name="min_persons" type="number" class="form-control" id="min_persons" placeholder="@lang('view/experience/create.practical.input.min-travelers')" required value="{{$experience->min_persons or Session::get('inputs')['min_persons']}}">
        <p class="help-block">@lang('view/experience/create.practical.help.min-travelers')</p>
        <p class="help-block text-error">@lang($errors->first('min_persons'))</p>
    </div>
</div>

<div class="form-group row has-feedback {{$errors->first('max_persons') ? 'has-error' : ''}}">
    <label for="max-travelers" class="col-md-2 control-label">@lang('view/experience/create.practical.input.max-travelers')</label>
    <div class="col-md-10">
        <input name="max_persons" type="number" class="form-control" id="max_persons" placeholder="@lang('view/experience/create.practical.input.max-travelers')" required value="{{$experience->max_persons or Session::get('inputs')['max_persons']}}">
        <p class="help-block">@lang('view/experience/create.practical.help.max-travelers')</p>
        <p class="help-block text-error">@lang($errors->first('max_persons'))</p>
    </div>
</div>
<?php
    if(isset($experience)) {
        $duration = $experience->duration;
        $minutes = $duration % 60;
        $duration = ($duration-$minutes)/60;
        $hours = $duration % 24;
        $days = ($duration-$hours)/24;
    }
    else {
        $minutes = Session::get('inputs')['time']['minutes'];
        $hours = Session::get('inputs')['time']['hours'];
        $days = Session::get('inputs')['time']['days'];
    }

?>
<div class="form-group row {{$errors->first('duration') ? 'has-error' : ''}}">
    <label for="duration" class="col-md-2 control-label">@lang('view/experience/create.practical.input.duration')</label>
    <div class="col-md-10">
        <div class="row" ng-init="days={{$days == 0 ? 'null' : $days}};hours={{$hours == 0 ? 'null' : $hours}};minutes={{$minutes == 0 ? 'null' : $minutes}}">
            <div class="col-md-4">
                <input ng-model="days" name="time[days]" type="number" class="form-control" placeholder="@lang('view/experience/create.practical.input.days')">
            </div>
            <div class="col-md-4">
                <input ng-model="hours" name="time[hours]" type="number" class="form-control" placeholder="@lang('view/experience/create.practical.input.hours')">
            </div>
            <div class="col-md-4">
                <input ng-model="minutes" name="time[minutes]" type="number" class="form-control" placeholder="@lang('view/experience/create.practical.input.minutes')">
            </div>
            <input type="text" ng-show="false" name="duration" ng-value="minutes + (hours + days * 24) * 60">
        </div>
        <p class="help-block">@lang('view/experience/create.practical.help.duration')</p>
        <p class="help-block text-error">@lang($errors->first('duration'))</p>
    </div>
</div>