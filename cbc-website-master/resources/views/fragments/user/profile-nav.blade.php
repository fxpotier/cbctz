<nav class="sidebar navbar-default" role="navigation" ng-init="sidebarCollapsed=true">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" ng-click="sidebarCollapsed = !sidebarCollapsed">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <p class="navbar-brand visible-xs">@lang('view/user/profile.collapse')</p>
    </div>
    <div class="collapse sidebar-nav navbar-collapse" collapse="sidebarCollapsed">
        <ul class="nav" id="side-menu">
            <li><a <?php if($menuProfileItem == 0) echo 'class="active"' ?> href="{{action('ProfileController@getIndex')}}">@lang('view/user/profile.edit.title')</a></li>
            <li><a <?php if($menuProfileItem == 1) echo 'class="active"' ?> href="{{action('ProfileController@getPictures')}}">@lang('view/user/profile.pictures.title')</a></li>
            <li><a <?php if($menuProfileItem == 2) echo 'class="active"' ?> href="{{action('ProfileController@getSettings')}}">@lang('view/user/profile.settings.title')</a></li>
            <li><a <?php if($menuProfileItem == 3) echo 'class="active"' ?> href="{{action('ProfileController@getBanking')}}">@lang('view/user/profile.banking.title')</a></li>
        </ul>
        <div class="text-center sidebar-button">
            <a class="btn btn-primary btn-block" href="{{action('ProfileController@getShow')}}">@lang('view/user/profile.view.title')</a>
        </div>
    </div>
</nav>
