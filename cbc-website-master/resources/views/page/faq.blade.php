@extends('layouts.base-no-container')

@section('title')
@lang('view/page/faq.meta.title')
@endsection

@section('description')
@lang('view/page/faq.meta.description')
@endsection

@section('body')
<div class="background-gray">
    <div class="container">
        <br/>
        <br/>
        <div class="panel panel-primary">
            <div class="panel-heading"><h1 class="text-inverse">@lang('view/page/faq.title')</h1></div>
            <div class="panel-body">
                <tabset justified="true">
                    <tab>
                        <tab-heading><h2>@lang('view/page/faq.traveler.title')</h2></tab-heading>
                        <div class="nav-border">
                            <accordion close-others="true">
                                @foreach(trans('view/page/faq.traveler.content') as $section)
                                    <h3>{{$section['title']}}</h3>
                                    @foreach($section['items'] as $item)
                                        @if(isset($item['q']))
                                        <accordion-group>
                                            <accordion-heading>{{$item['q']}}</accordion-heading>
                                            {!!$item['a']!!}
                                        </accordion-group>
                                        @else
                                        <p>{!!$item['a'] or ''!!}</p>
                                        @endif
                                    @endforeach
                                @endforeach
                            </accordion>
                        </div>
                    </tab>
                    <tab active="'{{$type or ''}}' == 'citizen'">
                        <tab-heading><h2>@lang('view/page/faq.citizen.title')</h2></tab-heading>
                        <div class="nav-border">
                            <accordion close-others="true">
                                @foreach(trans('view/page/faq.citizen.content') as $section)
                                    <h3>{{$section['title']}}</h3>
                                    @foreach($section['items'] as $item)
                                        @if(isset($item['q']))
                                            <accordion-group>
                                                <accordion-heading>{{$item['q']}}</accordion-heading>
                                                {!!$item['a']!!}
                                            </accordion-group>
                                        @else
                                        <p>{!!$item['a'] or ''!!}</p>
                                        @endif
                                    @endforeach
                                @endforeach
                            </accordion>
                        </div>
                    </tab>
                </tabset>
            </div>
        </div>
        <br/>
    </div>
</div>
@endsection