<div class="panel panel-primary">
    <div class="panel-heading">
        <h1 class="h2 text-inverse text-center">
            @if(isset($title))
                @lang($title)
            @else
                @lang('fragment/auth/signin.title', ['name' => $name])
            @endif
        </h1>
    </div>
    <div class="panel-body">
        @if(isset($social))
            <br/>
            @if(in_array('facebook', $social))<button class="btn btn-primary btn-block btn-lg" ng-click="signin('facebook')">@lang('fragment/auth/signin.inputs.facebook')</button>@endif
            <h3 class="text-center text-muted">@lang('fragment/auth/signin.by_mail')</h3>
        @endif
        @if(isset($error))
            <div class="alert alert-danger">
                {{$error}}
            </div>
        @endif
        <br/>
        <form action="{{action('AccountController@postSignIn')}}" method="post">
            <input type="hidden" name="_token" value="{{csrf_token()}}"/>
            <div class="form-group has-feedback">
                <div class="input-group">
                    <div class="input-group-addon">&nbsp;<span class="glyphicon glyphicon-user"></span>&nbsp;</div>
                    <input type="email" class="form-control input-lg" name="mail" placeholder="@lang('fragment/auth/signin.inputs.email')" value="{{$input['mail'] or ''}}" required>
                </div>
            </div>
            <div class="form-group has-feedback">
                <div class="input-group">
                    <div class="input-group-addon">&nbsp;<span class="glyphicon glyphicon-lock"></span>&nbsp;</div>
                    <input type="password" class="form-control input-lg" name="password" placeholder="@lang('fragment/auth/signin.inputs.password')" required>
                </div>
            </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="remember"/> @lang('fragment/auth/signin.inputs.remember')
                    </label>
                </div>
                <div>
                    <a href="{{action('AccountController@getForgotPassword')}}">@lang('fragment/auth/signin.forgot_password')</a>
                </div>
            <br/>
            <button class="btn btn-primary btn-lg btn-block" type="submit">
                @if(isset($button))
                    @lang($button)
                @else
                    @lang('fragment/auth/signin.inputs.signin')
                @endif
            </button>
        </form>
        <br/>
        @if(!isset($redirect) || $redirect === true)
        <div class="text-center">@lang('fragment/auth/signin.not_yet', ['name' => $name]) <a href="{{action('AccountController@getSignUp')}}">@lang('fragment/auth/signin.signup')</a></div>
        <br/>
        @endif
    </div>
</div>












