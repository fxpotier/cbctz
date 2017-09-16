@extends('layouts.user.full')

@section('styles')
    <link rel="stylesheet" href="{{asset('css/booking.css') }}"/>
    <link rel="stylesheet" href="{{asset('css/user.css') }}"/>
@endsection

@section('scripts')
	<script src="{{asset('js/user.js')}}"></script>
	<script src="{{asset('js/booking.js')}}"></script>
@endsection

@section('user-nav')
    @include('fragments.user.user-nav', ["menuItem" => 3])
@endsection

@section('title')
@lang('view/booking/index.meta.title')
@endsection

@section('description')
@lang('view/booking/index.meta.description')
@endsection

@section('body')
	<div class="index" ng-controller="IndexController">
		<div class="panel panel-default">
            <div class="panel-body">
                <h1>@lang('view/booking/index.title')</h1>
                <hr/>
                @if(count($asked)==0&&count($received)==0)
                    <br/>
                    <p class="text-center h2"><span class="text-muted">@lang('view/booking/index.none')</span></p>
                @endif
                @include('booking.fragments.state', ['state' => 'asked'])
                @include('booking.fragments.state', ['state' => 'booked'])
                @include('booking.fragments.state', ['state' => 'done'])
                @include('booking.fragments.state', ['state' => 'denied'])
                @include('booking.fragments.state', ['state' => 'canceled'])
                <br/>
                <br/>
            </div>
		</div>
	</div>
    <script type="text/ng-template" id="modalBooking.html">
        <div class="modal-header">
            <h3 class="modal-title">
                <span ng-if="state=='canceled'">@lang('view/booking/index.modal.title_cancel')</span>
                <span ng-if="state=='booked'">@lang('view/booking/index.modal.title_accept')</span>
                <span ng-if="state=='denied'">@lang('view/booking/index.modal.title_decline')</span>
            </h3>
        </div>
        <div class="modal-body">
            <div class="h4 text-muted">
                <div ng-if="state=='canceled'">@lang('view/booking/index.modal.text_cancel')</div>
                <div ng-if="state=='booked'">@lang('view/booking/index.modal.text_accept')</div>
                <div ng-if="state=='denied'">@lang('view/booking/index.modal.text_decline')</div>
            </div>
            <br/>
            <div><b>${title}</b></div>
            <div>${date | date:'dd/MM/yy - HH:mm'}</div>
            <div ng-if="persons==1">${persons} @choice('view/booking/index.people', 1)</div>
            <div ng-if="persons>1">${persons} @choice('view/booking/index.people', 2)</div>
            <br/>
        </div>
        <div class="modal-footer">
            <button class="btn btn-default" ng-click="ok()">@lang('view/booking/index.modal.yes')</button>
            <button class="btn btn-primary" ng-click="cancel()">@lang('view/booking/index.modal.no')</button>
        </div>
    </script>
    <script type="text/ng-template" id="modalFeedback.html">
        <form method="post" class="index" action="{{action('BookingController@postFeedback')}}">
            <div class="modal-header">
                <h3 class="modal-title">@lang('view/booking/index.modal.title_feedback')</h3>
            </div>
            <div class="modal-body">
                <input value="{{csrf_token()}}" type="hidden" name="_token"/>
                <input name="id" type="hidden" ng-value="id"/>
                <input name="role" type="hidden" ng-value="role"/>
                <div class="form-group row" ng-init="rate=5">
                    <label for="rate" class="col-md-2 control-label">@lang('view/booking/index.modal.rate')</label>
                    <div class="col-md-10">
                        <rating id="rate" class="rate-input" ng-model="rate" max="5" state-on="'fa fa-star'" state-off="'fa fa-star-o'"></rating>
                        <input name="rate" type="hidden" ng-value="rate">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="comment" class="col-md-2 control-label">@lang('view/booking/index.modal.comment')</label>
                    <div class="col-md-10">
                        <textarea name="comment" rows="5" type="text" class="form-control" id="comment" placeholder="@lang('view/booking/index.modal.comment')" required></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-default">@lang('view/booking/index.modal.save')</button>
                <button type="button" class="btn btn-primary" ng-click="cancel()">@lang('view/booking/index.modal.cancel')</button>
            </div>
        </form>
    </script>
@endsection