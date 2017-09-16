@extends('layouts.base-no-container')

@section('title')
@lang('view/page/terms.meta.title')
@endsection

@section('description')
@lang('view/page/terms.meta.description')
@endsection

@section('body')
<div class="background-gray">
    <div class="container">
        <br/>
        <br/>
        <div class="panel panel-primary">
            <div class="panel-heading"><h1 class="text-inverse">@lang('view/page/terms.title')</h1></div>
            <div class="panel-body text-justify" style="padding: 40px">
                <div class="text-center">
                    <img height="200px" src="{{asset('img/app/logo.svg')}}"/>
                </div>
                <br/>
                <p class="h1 text-center">@lang('view/page/terms.presentation.title')</p>
                <br/>
                <div class="row">
                    <p class="h3 text-default col-sm-10 col-sm-offset-1">@lang('view/page/terms.presentation.description')</p>
                </div>
                <br/>
                <br/>
                <h2 class="text-default">@lang('view/page/terms.cbc.title')</h2>
                @foreach(trans('view/page/terms.cbc.content') as $content)
                    <br/>
                    <h3 class="text-default">{{$content['title']}}</h3>
                    @foreach($content['paragraphs'] as $item)
                    <p>{!!$item!!}</p>
                    @endforeach
                @endforeach
                <br/>
                <h3 class="text-default text-center">@lang('view/page/terms.cbc.end')</h3>
                <br/>
                <br/>
                <br/>
                <div class="text-center">
                    <img height="90px" src="{{asset('img/app/Mangopay_logo.jpg')}}"/>
                </div>
                <br/>
                <h2 class="text-default">@lang('view/page/terms.mango.title')</h2>
                @foreach(trans('view/page/terms.mango.content') as $content)
                    <br/>
                    <h3 class="text-default">{{$content['title']}}</h3>
                    @foreach($content['paragraphs'] as $item)
                    <p>{!!$item!!}</p>
                    @endforeach
                @endforeach
                <br/>
                <h3 class="text-default text-center">@lang('view/page/terms.mango.end')</h3>
            </div>
        </div>
        <br/>
    </div>
</div>
@endsection