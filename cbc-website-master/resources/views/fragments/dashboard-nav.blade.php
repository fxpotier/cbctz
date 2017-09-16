<nav class="navbar navbar-default">
   <div class="container-fluid">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
         <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
             <span class="sr-only">Toggle navigation</span>
             <span class="icon-bar"></span>
             <span class="icon-bar"></span>
             <span class="icon-bar"></span>
         </button>
      </div>
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
         <ul class="nav navbar-nav">
            <li><a href="{{action('ProfileController@getIndex')}}">@lang('nav.dashboard.profile')</a></li>
            <li><a href="{{action('ExperienceDashboardController@getIndex')}}">@lang('nav.dashboard.experiences')</a></li>
            <li><a href="{{action('ProfileController@getIndex')}}">@lang('nav.dashboard.articles')</a></li>
            <li><a href="{{action('ProfileController@getIndex')}}">@lang('nav.dashboard.bookings')</a></li>
            <li><a href="{{action('ProfileController@getIndex')}}">@lang('nav.dashboard.analytics')</a></li>
         </ul>
      </div>
   </div>
</nav>