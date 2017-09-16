<!doctype HTML>
<html ng-app="cbc">
	<head>
		<title>@yield('title')</title>
		<meta name="description" content="@yield('description')">
		<meta name="robots" content="index,follow">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

		<link rel="shortcut icon" href="{{ asset('img/app/favicon.ico') }}">

		<script src="{{asset('js/libs.js')}}"></script>
		<script src="{{asset('js/SocialNetwork.js')}}"></script>
		<script src="{{asset('js/cbc.js')}}"></script>
		@yield('scripts')

		<link rel="stylesheet" href="{{asset('css/bootstrap.css') }}"/>
		<link rel="stylesheet" href="{{asset('css/font-awesome.css') }}"/>
		<link rel="stylesheet" href="{{asset('css/ng-tags-input.css') }}"/>
		<link rel="stylesheet" href="{{asset('css/ng-tags-input.bootstrap.css') }}"/>
		<link rel="stylesheet" href="{{asset('css/sb-admin-2.css') }}"/>
		<link rel="stylesheet" href="{{asset('css/app.css') }}"/>
		@yield('styles')
	</head>

	<body>
		@yield('content')
	</body>
</html>