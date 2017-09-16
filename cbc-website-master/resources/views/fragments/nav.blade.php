<nav class="navbar navbar-default" role="navigation" ng-init="navbarCollapsed=true">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" ng-click="navbarCollapsed = !navbarCollapsed">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="{{action('WelcomeController@getIndex')}}">
				@if(isset($home) && $home == true)
				<img class="logo" src="{{asset('img/app/logo-white.svg')}}" alt="City by Citizen"/>
				<img class="brand" src="{{asset('img/app/brand-white.png')}}" alt="City by Citizen"/>
				@else
				<img class="logo" src="{{asset('img/app/logo.svg')}}" alt="City by Citizen"/>
				<img class="brand" src="{{asset('img/app/brand.png')}}" alt="City by Citizen"/>
				@endif
			</a>
		</div>
		<div class="collapse navbar-collapse" collapse="navbarCollapsed">
		    @if(!Auth::check())
            <a class="btn btn-info btn-lg pull-right" style="margin-top:15px;margin-left:30px" href="{{action('AccountController@getSignUp')}}">@lang('fragment/app/nav.offer')</a>
            @endif
			<ul class="nav navbar-nav navbar-right">
			    <li class="divider-vertical divider-right"><a href="{{action('CronController@getIndex')}}">@lang('fragment/app/nav.blog')</a></li>
				@if(Auth::check())
					<li class="dropdown divider-vertical divider-right" dropdown>
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" dropdown-toggle>
							{{Auth::user()->user->firstname.' '.Auth::user()->user->lastname}}
							<span class="caret"></span>
						</a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="{{action('ProfileController@getIndex')}}">@lang('fragment/app/nav.dashboard.profile')</a></li>
							<li><a href="{{action('ExperienceController@getCreate')}}">@lang('fragment/app/nav.dashboard.experiences')</a></li>
							<li><a href="{{action('ArticleController@getIndex')}}">@lang('fragment/app/nav.dashboard.articles')</a></li>
							<li><a href="{{action('BookingController@getIndex')}}">@lang('fragment/app/nav.dashboard.bookings')</a></li>
							<li><a href="{{action('AnalyticController@getIndex')}}">@lang('fragment/app/nav.dashboard.analytics')</a></li>
							<li><a href="{{action('AccountController@getLogOut')}}">@lang('fragment/app/nav.logout')</a></li>
						</ul>
					</li>

                    @if ($rights->can('use_back_office'))
                        <li class="dropdown" dropdown>
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" dropdown-toggle>
                                Back Office<span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                @include('fragments.backOffice.dashboard-links')
                            </ul>
                        </li>
                    @endif
				@else
					<li class="divider-vertical divider-right"><a href="{{action('AccountController@getSignUp')}}">@lang('fragment/app/nav.signup')</a></li>
					<li><a href="{{action('AccountController@getSignIn')}}">@lang('fragment/app/nav.signin')</a></li>
				@endif
			</ul>
		</div>
	</div>
</nav>
