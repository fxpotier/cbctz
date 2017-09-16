@extends('layouts.root')

@section('content')
    @include('fragments.nav')
    @include('fragments.user.profile-nav')
    <div id="page-wrapper">
        <div class="clearfix">
            <div class="col-lg-offset-1 col-lg-10 container-min-height">
                @include('fragments.user.user-nav', ["menuItem" => 0])
                @yield('body')
            </div>
        </div>
        @include('fragments.footer.fluid')
    </div>
@endsection