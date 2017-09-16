<section class="community container text-center">
    <div class="row">
        <div class="col-xs-12">
            <h1>@lang('view/welcome.community.title')</h1>
            <p class="h4"><b>@lang('view/welcome.community.members')</b></p>
        </div>
    </div>
    <br/>
    <br/>
    <div class="row">
        <?php $i = 0 ?>
        @foreach($users as $user)
            <div class="col-sm-2 col-xs-3 thin-padding">
                <a href="{{action('ProfileController@getShow', $user->slug[0]->name)}}"><img class="fill" src="{{asset($user->profilePicture ? $user->profilePicture->source : 'img/app/users/no_profile.png')}}"></a>
            </div>
            @if($i == 3 || $i == 7)
            <div class="clearfix visible-xs-block"></div>
            @endif
            <?php $i++ ?>
        @endforeach
    </div>
</section>