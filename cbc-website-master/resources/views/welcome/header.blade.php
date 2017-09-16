<header ng-controller="headerController">
    <div class="jumbotron vertical-center-container header-background">
        <div class="text-center vertical-center">
            <div class="container">
                <div ng-click="stop()">
                    <video id="video" ng-class="{'fade-in':video}" controls src="{{asset('video/cbc.mp4')}}"></video>
                </div>
                <h1>@lang('view/welcome.header.title')</h1>
                <h2>@lang('view/welcome.header.find')</h2>
                <br/>
                @include('fragments.form.search')
                <br/>
                <button ng-click="play()" class="btn btn-primary btn-lg">
                    <b>
                        @lang('view/welcome.header.what')<br/>
                        @lang('view/welcome.header.cbc')<br/>
                        <span class="small">@lang('view/welcome.header.video')</span>
                    </b>
                </button>
            </div>
        </div>
    </div>
</header>