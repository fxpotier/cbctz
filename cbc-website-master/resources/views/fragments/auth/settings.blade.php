<div class="form-group row">
    <label for="mail" class="col-md-2 control-label">@lang('fragment/auth/settings.input.mail')</label>
    <div class="col-md-10">
        <input name="mail" type="email" class="form-control" id="mail" placeholder="@lang('fragment/auth/settings.input.mail')" value="{{$account->mail}}">
        <p class="help-block">{{$errors->first('mail')}}</p>
        <p class="help-block">@lang('fragment/auth/settings.help.mail')</p>
    </div>
</div>
<div class="form-group row">
    <label for="current_password" class="col-md-2 control-label">@lang('fragment/auth/settings.input.current_password')</label>
    <div class="col-md-10">
        <input name="current_password" type="password" class="form-control" id="current_password" placeholder="@lang('fragment/auth/settings.input.current_password')">
        <p class="help-block">{{$errors->first('current_password')}}</p>
        <p class="help-block">@lang('fragment/auth/settings.help.current_password')</p>
    </div>
</div>
<div class="form-group row">
    <label for="password" class="col-md-2 control-label">@lang('fragment/auth/settings.input.password')</label>
    <div class="col-md-10">
        <input name="password" type="password" class="form-control" id="password" placeholder="@lang('fragment/auth/settings.input.password')">
        <p class="help-block">{{$errors->first('password')}}</p>
        <p class="help-block">@lang('fragment/auth/settings.help.password')</p>
    </div>
</div>
<div class="form-group row">
    <label for="password_confirmation" class="col-md-2 control-label">@lang('fragment/auth/settings.input.password_confirmation')</label>
    <div class="col-md-10">
        <input name="password_confirmation" type="password" class="form-control" id="password_confirmation" placeholder="@lang('fragment/auth/settings.input.password_confirmation')">
        <p class="help-block">{{$errors->first('password_confirmation')}}</p>
        <p class="help-block">@lang('fragment/auth/settings.help.password_confirmation')</p>
    </div>
</div>