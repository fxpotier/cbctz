@extends('layouts.base-no-container')

@section('scripts')
    <script type="text/javascript" src="{{asset('js/welcome.js')}}"></script>
@endsection

@section('title')
@lang('view/search.meta.title', ['search' => implode(', ', json_decode($search))])
@endsection

@section('description')
@lang('view/search.meta.description', ['search' => implode(', ', json_decode($search))])
@endsection

@section('body')
    <section class="container"  ng-controller="headerController">
        <div class="text-center">
            <h1>@lang('view/search.results.title')</h1>
        </div>
        <br/>
        @include('fragments.form.search', ['search', $search])
        <br/>

        @if(empty($experiences))
            <div class="panel panel-default col-lg-8 col-lg-offset-2">
                <div class="panel-body">
                    <p class="text-center h2"><span class="text-muted">@lang('view/search.results.empty')</span></p>
                </div>
            </div>
        @else
            @include('fragments.experiences', $experiences)
        @endif
    </section>
@endsection