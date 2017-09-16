<div class="form-group row has-feedback {{$errors->first('firstname') ? 'has-error' : ''}}">
    <label for="firstname" class="col-md-2 control-label">@lang('fragment/form/identity.input.firstname')</label>
    <div class="col-md-10">
        <input name="firstname" required type="text" class="form-control" id="firstname" placeholder="@lang('fragment/form/identity.input.firstname')" value="{{$user->firstname}}">
        <p class="help-block">@lang('fragment/form/identity.help.firstname')</p>
        <p class="help-block text-error">@lang($errors->first('firstname'))</p>
    </div>
</div>
<div class="form-group row has-feedback {{$errors->first('lastname') ? 'has-error' : ''}}">
    <label for="lastname" class="col-md-2 control-label">@lang('fragment/form/identity.input.lastname')</label>
    <div class="col-md-10">
        <input name="lastname" type="text" required class="form-control" id="lastname" placeholder="@lang('fragment/form/identity.input.lastname')" value="{{$user->lastname}}">
        <p class="help-block">@lang('fragment/form/identity.help.lastname')</p>
        <p class="help-block text-error">@lang($errors->first('lastname'))</p>
    </div>
</div>
<div class="form-group row has-feedback {{$errors->first('gender') ? 'has-error' : ''}}">
    <label for="gender" class="col-md-2 control-label">@lang('fragment/form/identity.input.gender')</label>
    <div class="col-md-10">
        <?php $i=1 ?>
        <select name="gender" class="form-control">
            @foreach(trans('fragment/form/identity.genders') as $gender)
                <option @if($i == $user->gender) {{'selected'}} @endif value="{{$i++}}">{{$gender}}</option>
            @endforeach
        </select>
        <p class="help-block text-error">@lang($errors->first('gender'))</p>
    </div>
</div>
<div class="form-group row">
    <label class="col-md-2 control-label">@lang('fragment/form/identity.input.birthdate')</label>
    <div class="col-md-10">
        <div class="row">
            <?php $birthdate = explode('-', $user->birthdate) ?>
            <div class="col-md-4">
                <select name="date[day]" class="form-control">
                    @for($i=1;$i<=31;$i++)
                        <option @if($i ==  explode(' ', $birthdate[2])[0]) {{'selected'}} @endif value="{{$i}}">{{$i}}</option>
                    @endfor
                </select>
            </div>
            <div class="col-md-4">
                <?php $i=1 ?>
                <select name="date[month]" class="form-control">
                    @foreach(trans('utils/date.months') as $month)
                        <option @if($i == $birthdate[1]) {{'selected'}} @endif value="{{$i++}}">{{$month}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <select name="date[year]" class="form-control">
                    @for($i=date("Y");$i>=date("Y")-125;$i--)
                        <option @if($i == $birthdate[0]) {{'selected'}} @endif value="{{$i}}">{{$i}}</option>
                    @endfor
                </select>
            </div>
        </div>
        <p class="help-block">@lang('fragment/form/identity.help.birthdate')</p>
        <p class="help-block text-error">@lang($errors->first('date'))</p>
    </div>
</div>
<div class="form-group row has-feedback {{$errors->first('nationality') ? 'has-error' : ''}}">
    <label for="nationality" class="col-md-2 control-label">@lang('fragment/form/identity.input.nationality')</label>
    <div class="col-md-10">
        <select id="nationality" name="nationality" class="form-control">
            @foreach(trans('utils/countries') as $country)
                <option @if($country['code'] == $user->nationality) {{'selected'}} @endif value="{{$country['code']}}">{{$country['name']}}</option>
            @endforeach
        </select>
        <p class="help-block text-error">@lang($errors->first('nationality'))</p>
    </div>
</div>
<div class="form-group row has-feedback {{$errors->first('phone') ? 'has-error' : ''}}">
    <label for="phone" class="col-md-2 control-label">@lang('fragment/form/identity.input.phone')</label>
    <div class="col-md-10">
        <input name="phone" type="tel" class="form-control" id="phone" placeholder="@lang('fragment/form/identity.input.phone')" value="{{$user->phone}}">
        <p class="help-block">@lang('fragment/form/identity.help.phone')</p>
        <p class="help-block text-error">@lang($errors->first('phone'))</p>
    </div>
</div>