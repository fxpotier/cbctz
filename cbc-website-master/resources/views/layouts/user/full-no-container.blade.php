@extends('layouts.root')

@section('content')
    @include('fragments.nav')
    <div class="container">
        @yield('user-nav')
    </div>
    @yield('body')
    @include('fragments.footer.fluid')
@endsection