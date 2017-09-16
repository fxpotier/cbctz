<div class="form-group row has-feedback {{$errors->first('street') ? 'has-error' : ''}}">
    <label for="address" class="col-md-2 control-label">@lang('fragment/form/address.input.street')</label>
    <div class="col-md-10">
        <input name="address[street]" type="text" class="form-control" id="address" placeholder="@lang('fragment/form/address.input.street')" value="{{isset($user->address) ? $user->address->street : ''}}">
        <p class="help-block">@lang('fragment/form/address.help.street')</p>
        <p class="help-block text-error">@lang($errors->first('street'))</p>
    </div>
</div>
<div class="form-group row has-feedback {{$errors->first('zipcode') ? 'has-error' : ''}}">
    <label for="zipcode" class="col-md-2 control-label">@lang('fragment/form/address.input.zipcode')</label>
    <div class="col-md-10">
        <input name="address[zipcode]" type="text" class="form-control" id="zipcode" placeholder="@lang('fragment/form/address.input.zipcode')" value="{{isset($user->address) ? $user->address->zipcode : ''}}">
        <p class="help-block">@lang('fragment/form/address.help.zipcode')</p>
        <p class="help-block text-error">@lang($errors->first('zipcode'))</p>
    </div>
</div>
<div class="form-group row has-feedback {{$errors->first('city') ? 'has-error' : ''}}">
    <label for="city" class="col-md-2 control-label">@lang('fragment/form/address.input.city')</label>
    <div class="col-md-10">
        <input name="address[city]" type="text" class="form-control" id="city" placeholder="@lang('fragment/form/address.input.city')" value="{{isset($user->address) ? $user->address->city : ''}}">
        <p class="help-block">@lang('fragment/form/address.help.city')</p>
        <p class="help-block text-error">@lang($errors->first('city'))</p>
    </div>
</div>
<div class="form-group row has-feedback {{$errors->first('country') ? 'has-error' : ''}}">
    <label for="country" class="col-md-2 control-label">@lang('fragment/form/address.input.country')</label>
    <div class="col-md-10">
        <select id="country" name="address[country]" class="form-control">
            @foreach(trans('utils/countries') as $country)
                <option @if(isset($user->address) && $country['code'] == $user->address->country) {{'selected'}} @endif value="{{$country['code']}}">{{$country['name']}}</option>
            @endforeach
        </select>
        <p class="help-block">@lang('fragment/form/address.help.country')</p>
        <p class="help-block text-error">@lang($errors->first('country'))</p>
    </div>
</div>