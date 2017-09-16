<br/>
<br/>
<div class="row">
    <div class="col-md-3 col-sm-4">
        <em class="h4"><b>@lang('fragment/app/footer.about.title')</b></em>
        <br/>
        <br/>
        <div><a href="{{action('PageController@getAbout')}}">@lang('fragment/app/footer.about.who')</a></div>
        <div><a href="{{action('WelcomeController@getIndex') . '#instructions'}}">@lang('fragment/app/footer.about.how')</a></div>
        <div><a href="{{action('PageController@getFaq')}}">@lang('fragment/app/footer.about.faq-traveler')</a></div>
        <div><a href="{{action('PageController@getFaq', 'citizen')}}">@lang('fragment/app/footer.about.faq-citizen')</a></div>
        <div><a href="{{action('PageController@getPress')}}">@lang('fragment/app/footer.about.press')</a></div>
        <br class="hidden-xs" />
        <div><a href="{{action('PageController@getTerms')}}"><b>@lang('fragment/app/footer.about.terms')</b></a></div>
    </div>
    <div class="col-md-6 col-sm-4">
        <br class="visible-xs" />
        <em class="h4"><b>@lang('fragment/app/footer.contact.title')</b></em>
        <br/>
        <br/>
        <address>
            <div>@lang('fragment/app/footer.contact.street')</div>
            <div>@lang('fragment/app/footer.contact.city')</div>
            <div>@lang('fragment/app/footer.contact.country')</div>
            <br/>
            <div>@lang('fragment/app/footer.contact.phone')</div>
            <a href="mailto:@lang('fragment/app/footer.contact.mail')">@lang('fragment/app/footer.contact.mail')</a>
        </address>
    </div>
    <div class="col-md-3  col-sm-4 text-center">
        <img class="logo" src="{{asset('img/app/logo.svg')}}" alt="City by Citizen"/>
        <br/>
        <br/>
        <p><b>@lang('fragment/app/footer.network.made') <span class="glyphicon glyphicon-heart"></span> @lang('fragment/app/footer.network.city')</b></p>
        <div class="h3">
            <a href="" target="_blank" class="social-network img-circle"><span class="fa fa-facebook"></span></a>
            <a href="" target="_blank" class="social-network img-circle"><span class="fa fa-twitter"></span></a>
            <a href="" target="_blank" class="social-network img-circle"><span class="fa fa-instagram"></span></a>
            <a href="" target="_blank" class="social-network img-circle"><span class="fa fa-linkedin"></span></a>
        </div>
    </div>
</div>