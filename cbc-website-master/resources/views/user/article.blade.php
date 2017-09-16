@extends('layouts.user.full')

@section('styles')
    <link rel="stylesheet" href="{{asset('css/user.css') }}"/>
@endsection

@section('scripts')
	<script src="{{asset('js/user.js')}}"></script>
@endsection

@section('title')
    @lang('view/user/article.meta.title')
@endsection

@section('description')
    @lang('view/user/article.meta.description')
@endsection

@section('user-nav')
    @include('fragments.user.user-nav', ["menuItem" => 2])
@endsection

@section('body')
	<div>
		<div class="panel panel-default">
            <div class="panel-body">
                <h1>@lang('view/user/article.title')</h1>
                <hr/>
                <br/>
            </div>
		</div>
	</div>
@endsection