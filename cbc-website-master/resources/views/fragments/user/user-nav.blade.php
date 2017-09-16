<ul class="nav nav-pills nav-justified">
    <li <?php if($menuItem == 0) echo 'class="active"' ?> role="presentation"><a href="{{action('ProfileController@getIndex')}}">@lang('view/user/menu.profile')</a></li>
    <li <?php if($menuItem == 1) echo 'class="active"' ?> role="presentation"><a href="{{action('ExperienceController@getCreate')}}">@lang('view/user/menu.experiences')</a></li>
    <li <?php if($menuItem == 2) echo 'class="active"' ?> role="presentation"><a href="{{action('ArticleController@getIndex')}}">@lang('view/user/menu.articles')</a></li>
    <li <?php if($menuItem == 3) echo 'class="active"' ?> role="presentation"><a href="{{action('BookingController@getIndex')}}">@lang('view/user/menu.bookings')</a></li>
    <li <?php if($menuItem == 4) echo 'class="active"' ?> role="presentation"><a href="{{action('AnalyticController@getIndex')}}">@lang('view/user/menu.analytics')</a></li>
</ul>
