<section class="background-inverse instructions" id="instructions">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h1 class="text-center">@lang('view/welcome.instructions.title')</h1>
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="col-sm-6 traveler">
                <h2 class="text-center h4">@lang('view/welcome.instructions.traveler.title')</h2>
                <br/>
                <div class="divider-vertical divider-right">
                    <div class="row">
                        <div class="col-sm-4 col-lg-3"><img src="{{asset('img/app/welcome/instructions/traveler-1.png')}}"/></div>
                        <div class="col-sm-8 col-lg-9 vertical-center">
                            @lang('view/welcome.instructions.traveler.item1')
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 col-lg-3"><img src="{{asset('img/app/welcome/instructions/common-2.png')}}"/></div>
                        <div class="col-sm-8 col-lg-9 vertical-center">@lang('view/welcome.instructions.traveler.item2')</div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 col-lg-3"><img src="{{asset('img/app/welcome/instructions/traveler-3.png')}}"/></div>
                        <div class="col-sm-8 col-lg-9 vertical-center">@lang('view/welcome.instructions.traveler.item3')</div>
                    </div>
                </div>
            </div>
            <br class="visible-xs"/>
            <div class="col-sm-6 citizen">
                <h2 class="text-center h4">@lang('view/welcome.instructions.citizen.title')</h2>
                <br/>
                <div>
                    <div class="row">
                        <div class="col-sm-8 col-lg-9 vertical-center">@lang('view/welcome.instructions.citizen.item1')</div>
                        <div class="col-sm-4 col-lg-3"><img src="{{asset('img/app/welcome/instructions/citizen-1.png')}}"/></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-8 col-lg-9 vertical-center">@lang('view/welcome.instructions.citizen.item2')</div>
                        <div class="col-sm-4 col-lg-3"><img src="{{asset('img/app/welcome/instructions/common-2.png')}}"/></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-8 col-lg-9 vertical-center">@lang('view/welcome.instructions.citizen.item3')</div>
                        <div class="col-sm-4 col-lg-3"><img src="{{asset('img/app/welcome/instructions/citizen-3.png')}}"/></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
