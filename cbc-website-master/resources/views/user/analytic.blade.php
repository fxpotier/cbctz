@extends('layouts.user.full')

@section('styles')
    <link rel="stylesheet" href="{{asset('css/user.css') }}"/>
@endsection

@section('scripts')
	<script src="{{asset('js/user.js')}}"></script>
@endsection

@section('title')
    @lang('view/user/analytic.meta.title')
@endsection

@section('description')
    @lang('view/user/analytic.meta.description')
@endsection

@section('user-nav')
    @include('fragments.user.user-nav', ["menuItem" => 4])
@endsection

@section('body')
	<div>
		<div class="panel panel-default">
            <div class="panel-body">
                <h1>@lang('view/user/analytic.title')</h1>
                <hr/>
                <br/>
                <div class="text-center h1">@lang('view/user/analytic.coming')!</div>
                <br/>
                <br/>
            </div>
		</div>
	</div>
@endsection