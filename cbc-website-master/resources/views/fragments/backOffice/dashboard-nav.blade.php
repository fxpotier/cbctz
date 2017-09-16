<!--<ta-navbar side class="col-sm-2 sidebar-offset" fixed="left">
	<brand>@lang('back-office.title')</brand>
	<ta-navbar-group>
		<ta-navbar-link href="{{action('ProfileController@getIndex')}}">@lang('back-office.dashboard.title')</ta-navbar-link>
		<ta-navbar-link href="{{action('ProfileController@getIndex')}}">@lang('back-office.user.title')</ta-navbar-link>
		<ta-navbar-link href="{{action('ProfileController@getIndex')}}">@lang('back-office.experience.title')</ta-navbar-link>
		<ta-navbar-link href="{{action('ProfileController@getIndex')}}">@lang('back-office.booking.title')</ta-navbar-link>
		<ta-navbar-link href="{{action('ProfileController@getIndex')}}">@lang('back-office.request.title')</ta-navbar-link>
		<ta-navbar-link href="{{action('ProfileController@getIndex')}}">@lang('back-office.blog.title')</ta-navbar-link>
		<ta-navbar-link href="{{action('ProfileController@getIndex')}}">@lang('back-office.notification.title')</ta-navbar-link>
		<ta-navbar-link href="{{action('ProfileController@getIndex')}}">@lang('back-office.tag.title')</ta-navbar-link>
		<ta-navbar-link href="{{action('ProfileController@getIndex')}}">@lang('back-office.category.title')</ta-navbar-link>
		<ta-navbar-link href="{{action('ProfileController@getIndex')}}">@lang('back-office.setting.title')</ta-navbar-link>
		<ta-navbar-link href="{{action('ProfileController@getIndex')}}">@lang('back-office.language.title')</ta-navbar-link>
	</ta-navbar-group>
</ta-navbar>-->

<nav class="navbar navbar-default">
	<div class="container-fluid">
		<ul class="nav navbar-nav">
			@include('fragments.backOffice.dashboard-links')
		</ul>
	</div>
</nav>
