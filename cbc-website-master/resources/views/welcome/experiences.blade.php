<section class="experiences container">
    <div class="row text-center">
        <div class="col-xs-12">
            <h1>@lang('view/welcome.experiences.title')</h1>
            <p class="h4"><b>@lang('view/welcome.experiences.title-help')</b></p>
        </div>
    </div>
    <br/>
    <br/>
    <div class="row">
        @include('fragments.experiences', [$experiences])
    </div>
</section>