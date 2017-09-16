<div class="form-group row">
    <label for="cardType" class="col-md-2 control-label">@lang('fragment/form/payment.input.card-type')</label>
    <div class="col-md-10">
        <select name="cardType" class="form-control">
            @foreach(trans('fragment/form/payment.card-types') as $key => $type)
                <option value="{{$key}}">{{$type}}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="form-group row has-feedback {{$errors->first('cardNumber') ? 'has-error' : ''}}">
    <label for="cardNumber" class="col-md-2 control-label">@lang('fragment/form/payment.input.card-number')</label>
    <div class="col-md-10">
        <input name="cardNumber" type="text" class="form-control" id="cardNumber" placeholder="@lang('fragment/form/payment.input.card-number')">
        <p class="help-block">@lang('fragment/form/payment.help.card-number')</p>
        <p class="help-block text-error">@lang($errors->first('cardNumber'))</p>
    </div>
</div>
<div class="form-group row has-feedback {{$errors->first('cardExpirationDate') ? 'has-error' : ''}}">
    <label for="cardExpirationDate" class="col-md-2 control-label">@lang('fragment/form/payment.input.expiration')</label>
    <div class="col-md-10">
        <input name="cardExpirationDate" type="text" class="form-control" id="cardExpirationDate" placeholder="@lang('fragment/form/payment.input.expiration')">
        <p class="help-block">@lang('fragment/form/payment.help.expiration')</p>
        <p class="help-block text-error">@lang($errors->first('cardExpirationDate'))</p>
    </div>
</div>
<div class="form-group row has-feedback {{$errors->first('cardCvx') ? 'has-error' : ''}}">
    <label for="cardCvx" class="col-md-2 control-label">@lang('fragment/form/payment.input.cvv')</label>
    <div class="col-md-10">
        <input name="cardCvx" type="text" class="form-control" id="cardCvx" placeholder="@lang('fragment/form/payment.input.cvv')">
        <p class="help-block">@lang('fragment/form/payment.help.cvv')</p>
        <p class="help-block text-error">@lang($errors->first('cardCvx'))</p>
    </div>
</div>