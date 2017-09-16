<div class="panel panel-primary">
    <div class="panel-heading">
        <h1 class="h2 text-inverse text-center">
            @if(isset($title))
                @lang($title)
            @else
                @lang('fragment/auth/signup.title', ['name' => $name])
            @endif
        </h1>
    </div>
    <div class="panel-body">
        @if(isset($social))
            <br/>
            @if(in_array('facebook', $social))<button class="btn btn-primary btn-block btn-lg" ng-click="signup('facebook')">@lang('fragment/auth/signup.inputs.facebook')</button>@endif
            <h3 class="text-center text-muted">@lang('fragment/auth/signup.by_mail')</h3>
        @endif
        <br/>
        <form action="{{action('AccountController@postSignUp')}}" method="post">
            <input type="hidden" name="_token" value="{{csrf_token()}}"/>
            @if(isset($identity) && $identity === true)
            <div class="row">
                <div class="col-xs-6 form-group thin-padding-right">
                    <div class="input-group-lg {{$errors->first('firstname') ? 'has-error' : ''}}">
                        <input class="form-control" name="firstname" placeholder="@lang('fragment/auth/signup.inputs.firstname')" value="{{$input['firstname'] or ''}}" type="text" required/>
                    </div>
                    {{$errors->first('firstname')}}
                </div>
                <div class="col-xs-6 form-group thin-padding-left">
                    <div class="input-group-lg {{$errors->first('lastname') ? 'has-error' : ''}}">
                        <input class="form-control" name="lastname" placeholder="@lang('fragment/auth/signup.inputs.lastname')" value="{{$input['lastname'] or ''}}" type="text" required/>
                    </div>
                    {{$errors->first('lastname')}}
                </div>
            </div>
            @endif
            {{$errors->first('mail')}}
            <div class="form-group has-feedback {{$errors->first('mail') ? 'has-error' : ''}}">
                <div class="input-group">
                    <div class="input-group-addon">&nbsp;<span class="glyphicon glyphicon-user"></span>&nbsp;</div>
                    <input type="email" class="form-control input-lg" name="mail" placeholder="@lang('fragment/auth/signup.inputs.email')" value="{{$input['mail'] or ''}}" required>
                </div>
            </div>
            {{$errors->first('password')}}
            <div class="form-group has-feedback {{$errors->first('password') ? 'has-error' : ''}}">
                <div class="input-group">
                    <div class="input-group-addon">&nbsp;<span class="glyphicon glyphicon-lock"></span>&nbsp;</div>
                    <input type="password" class="form-control input-lg" name="password" placeholder="@lang('fragment/auth/signup.inputs.password')" required>
                </div>
            </div>
            <div class="form-group has-feedback">
                <div class="input-group">
                    <div class="input-group-addon">&nbsp;<span class="glyphicon glyphicon-lock"></span>&nbsp;</div>
                    <input type="password" class="form-control input-lg" name="password_confirmation" placeholder="@lang('fragment/auth/signup.inputs.password_confirm')" required>
                </div>
            </div>
            <br/>
            <button class="btn btn-primary btn-lg btn-block" type="submit">
                @if(isset($button))
                    @lang($button)
                @else
                    @lang('fragment/auth/signup.inputs.signup')
                @endif
            </button>
        </form>
        <br/>
        @if(!isset($redirect) || $redirect === true)
        <div class="text-center">@lang('fragment/auth/signup.already_on', ['name' => $name]) <a href="{{action('AccountController@getSignIn')}}">@lang('fragment/auth/signup.signin')</a></div>
        <br/>
        @endif
    </div>
</div>