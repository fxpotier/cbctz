@extends('layouts.base')

@section('body')
	<div class="alert alert-{{$type}}">
		{{$message}}
	</div>
@endsection