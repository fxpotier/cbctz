@extends('layouts.base-no-container')

@section('styles')
    <link rel="stylesheet" href="{{asset('css/pages.css') }}"/>
@endsection

@section('title')
@lang('view/page/about.meta.title')
@endsection

@section('description')
@lang('view/page/about.meta.description')
@endsection

@section('body')
<div class="background-gray">
    <div class="container about">
        <br/>
        <br/>
        <div class="panel panel-primary">
            <div class="panel-heading about-heading" style="background-image: url('{{asset('img/app/pages/about-header.jpg')}}')">
                <h1 class="text-inverse">@lang('view/page/about.title')</h1>
            </div>
            <div class="panel-body">
                <p>@lang('view/page/about.start')</p>
                <br/>
                <br/>
                <div class="row">
                    <div class="col-sm-4 text-center">
                        <div>
                            <img src="{{asset('img/app/pages/fx.jpg')}}" alt="François-Xavier">
                        </div>
                        <br/>
                        <p>@lang('view/page/about.fx')</p>
                    </div>
                    <div class="col-sm-4 text-center">
                        <div>
                            <img src="{{asset('img/app/pages/ben.jpg')}}" alt="Benjamin">
                        </div>
                        <br/>
                        <p>@lang('view/page/about.ben')</p>
                    </div>
                    <div class="col-sm-4 text-center">
                        <div>
                            <img src="{{asset('img/app/pages/ta.jpg')}}" alt="Thunder Arrow">
                        </div>
                        <br/>
                        <p>@lang('view/page/about.ta')</p>
                    </div>
                </div>
            </div>
            <div class="panel-footer" style="background-image: url('{{asset('img/app/pages/about-footer.jpg')}}')">
                <br/>
                <p class="h3 text-inverse">@lang('view/page/about.end')</p>
            </div>
        </div>
        <br/>
    </div>
</div>
@endsection