@extends('layouts.root')

@section('content')
    @include('fragments.nav')
    <div class="container container-min-height">
        @yield('user-nav')
        @yield('body')
    </div>
    @include('fragments.footer.fluid')
@endsection