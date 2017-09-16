<div class="form-group row has-feedback {{$errors->first('costs.tips.per_person') || $errors->first('costs.tips.value') ? 'has-error' : ''}}">
    <label for="tips" class="col-md-2 control-label">@lang('view/experience/create.price.input.tips')</label>
    <div class="col-md-10">
        <div class="input-group">
            <div class="input-group-addon bg-primary">
                <input name="costs[tips][per_person]" type="checkbox" ng-checked="{{$prices['suggested']['per_person'] or isset(Session::get('inputs')['costs']['tips']['per_person']) && Session::get('inputs')['costs']['tips']['per_person'] === 'on'}}"> @lang('view/experience/create.price.input.per-person')
            </div>
            <!-- Session::get('inputs')['costs.tips.value'] -->
            <input name="costs[tips][value]" type="number" class="form-control" id="max_persons" placeholder="@lang('view/experience/create.price.input.tips')" required  value="{{$prices['suggested']['cost'] or Session::get('inputs')['costs']['tips']['value']}}">
            <div class="input-group-addon">&nbsp;€&nbsp;</div>
        </div>
        <p class="help-block">@lang('view/experience/create.price.help.tips')</p>
        <p class="help-block text-error">
            @lang($errors->first('costs.tips.per_person')) @lang($errors->first('costs.tips.value'))
        </p>
    </div>
</div>
<div class="form-group row has-feedback {{$errors->first('costs.food.per_person') || $errors->first('costs.food.value') ? 'has-error' : ''}}">
    <label for="food" class="col-md-2 control-label">@lang('view/experience/create.price.input.food')</label>
    <div class="col-md-10">
        <div class="input-group">
            <div class="input-group-addon bg-primary">
                <input name="costs[food][per_person]" type="checkbox" ng-checked="{{$prices['food']['per_person'] or isset(Session::get('inputs')['costs']['food']['per_person']) && Session::get('inputs')['costs']['food']['per_person'] === 'on'}}"> @lang('view/experience/create.price.input.per-person')
            </div>
            <input name="costs[food][value]" type="number" class="form-control" id="max_persons" placeholder="@lang('view/experience/create.price.input.food')" value="{{$prices['food']['cost'] or Session::get('inputs')['costs']['food']['value']}}">
            <div class="input-group-addon">&nbsp;€&nbsp;</div>
        </div>
        <p class="help-block">@lang('view/experience/create.price.help.food')</p>
        <p class="help-block text-error">
            @lang($errors->first('costs.food.per_person')) @lang($errors->first('costs.food.value'))
        </p>
    </div>
</div>
<div class="form-group row has-feedback {{$errors->first('costs.transportation.per_person') || $errors->first('costs.transportation.value') ? 'has-error' : ''}}">
    <label for="transportation" class="col-md-2 control-label">@lang('view/experience/create.price.input.transportation')</label>
    <div class="col-md-10">
        <div class="input-group">
            <div class="input-group-addon bg-primary">
                <input name="costs[transportation][per_person]" type="checkbox" ng-checked="{{$prices['transportation']['per_person'] or isset(Session::get('inputs')['costs']['transportation']['per_person']) && Session::get('inputs')['costs']['transportation']['per_person'] === 'on'}}"> @lang('view/experience/create.price.input.per-person')
            </div>
            <input name="costs[transportation][value]" type="number" class="form-control" id="max_persons" placeholder="@lang('view/experience/create.price.input.transportation')" value="{{$prices['transportation']['cost'] or Session::get('inputs')['costs']['transportation']['value']}}">
            <div class="input-group-addon">&nbsp;€&nbsp;</div>
        </div>
        <p class="help-block">@lang('view/experience/create.price.help.transportation')</p>
        <p class="help-block text-error">
            @lang($errors->first('costs.transportation.per_person')) @lang($errors->first('costs.transportation.value'))
        </p>
    </div>
</div>
<div class="form-group row has-feedback {{$errors->first('costs.ticket.per_person') || $errors->first('costs.ticket.value') ? 'has-error' : ''}}">
    <label for="ticket" class="col-md-2 control-label">@lang('view/experience/create.price.input.ticket')</label>
    <div class="col-md-10">
        <div class="input-group">
            <div class="input-group-addon bg-primary">
                <input name="costs[ticket][per_person]" type="checkbox" ng-checked="{{$prices['ticket']['per_person'] or isset(Session::get('inputs')['costs']['ticket']['per_person']) && Session::get('inputs')['costs']['ticket']['per_person'] === 'on'}}"> @lang('view/experience/create.price.input.per-person')
            </div>
            <input name="costs[ticket][value]" type="number" class="form-control" id="max_persons" placeholder="@lang('view/experience/create.price.input.ticket')" value="{{$prices['ticket']['cost'] or Session::get('inputs')['costs']['ticket']['value']}}">
            <div class="input-group-addon">&nbsp;€&nbsp;</div>
        </div>
        <p class="help-block">@lang('view/experience/create.price.help.ticket')</p>
        <p class="help-block text-error">
            @lang($errors->first('costs.ticket.per_person')) @lang($errors->first('costs.ticket.value'))
        </p>
    </div>
</div>
<div class="form-group row has-feedback {{$errors->first('costs.other.per_person') || $errors->first('costs.other.value') ? 'has-error' : ''}}">
    <label for="other" class="col-md-2 control-label">@lang('view/experience/create.price.input.other')</label>
    <div class="col-md-10">
        <div class="input-group">
            <div class="input-group-addon bg-primary">
                <input name="costs[other][per_person]" type="checkbox" ng-checked="{{$prices['other']['per_person'] or isset(Session::get('inputs')['costs']['other']['per_person']) && Session::get('inputs')['costs']['other']['per_person'] === 'on'}}"> @lang('view/experience/create.price.input.per-person')
            </div>
            <input name="costs[other][value]" type="number" class="form-control" id="max_persons" placeholder="@lang('view/experience/create.price.input.other')" value="{{$prices['other']['cost'] or Session::get('inputs')['costs']['other']['value']}}">
            <div class="input-group-addon">&nbsp;€&nbsp;</div>
        </div>
        <p class="help-block">@lang('view/experience/create.price.help.other')</p>
        <p class="help-block text-error">
            @lang($errors->first('costs.other.per_person')) @lang($errors->first('costs.other.value'))
        </p>
    </div>
</div>