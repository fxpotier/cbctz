@extends('layouts.base-no-container')

@section('title')
@lang('view/page/press.meta.title')
@endsection

@section('description')
@lang('view/page/press.meta.description')
@endsection

@section('body')
<div class="background-gray">
    <div class="container">
        <br/>
        <br/>
        <div class="panel panel-primary">
            <div class="panel-heading"><h1 class="text-inverse">@lang('view/page/press.title')</h1></div>
            <div class="panel-body text-justify">
                <br/>
                <h2 class="text-center">@lang('view/page/press.subtitle')</h2>
                <br/>
                @foreach(trans('view/page/press.content') as $item)
                    <h3>{{$item['title']}}</h3>
                    @foreach($item['paragraphs'] as $paragraph)
                        <p>{!!$paragraph!!}</p>
                    @endforeach
                @endforeach
            </div>
            <div class="background-inverse" style="padding: 15px">
                <h3>@lang('view/page/press.more.title')</h3>
                <p>@lang('view/page/press.more.content')</p>
                <h3>@lang('view/page/press.contact.title')</h3>
                <p>@lang('view/page/press.contact.street')<br/>@lang('view/page/press.contact.city')</p>
                <p>@lang('view/page/press.contact.phone')<br/>@lang('view/page/press.contact.mail')</p>
            </div>
            <div class="text-center">
                <br/>
                <a href="{{asset('documents/press.pdf')}}" target="_blank" class="btn btn-primary btn-lg">@lang('view/page/press.download')</a>
                <br/>
                <br/>
            </div>
        </div>
        <br/>
    </div>
</div>
@endsection