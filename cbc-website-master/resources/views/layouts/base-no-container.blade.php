@extends('layouts.root')

@section('content')
    @include('fragments.nav')
    @yield('before-body')
    @yield('body')
    @include('fragments.footer.basic')
@endsection