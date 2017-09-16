@extends('layouts.root')

@section('content')
    @include('fragments.nav')
    @yield('before-body')
    <div class="container">
        @yield('body')
    </div>
    @yield('after-body')
    @include('fragments.footer.basic')
@endsection