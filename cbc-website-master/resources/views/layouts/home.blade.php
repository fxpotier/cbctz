@extends('layouts.root')

@section('content')
	@include('fragments.nav', ['home' => true])
	@yield('before-body')
	@yield('body')
	@include('fragments.footer.basic')
@endsection