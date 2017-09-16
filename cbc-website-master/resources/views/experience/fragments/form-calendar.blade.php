<div class="row">
    <div class="col-sm-6 col-lg-5">
        <datepicker ng-model="selectedDate" min-date="minDate" show-weeks="false" class="date-picker" date-disabled="disabled(date)" custom-class="getDayClass(date)"></datepicker>
        <br/>
        <p>
            <span ng-show="!period">@lang('view/experience/calendar.date.selected')&nbsp;</span>
            <span ng-show="period">@lang('view/experience/calendar.date.selected-from')&nbsp;</span> ${selectedDate|date:'dd/MM/yyyy'}
            <span ng-show="period">&nbsp;@lang('view/experience/calendar.date.to')&nbsp;${period|date:'dd/MM/yyyy'}</span>
        </p>
        <p ng-show="!period">
            <a ng-click="enablePeriod(selectedDate, $event)">@lang('view/experience/calendar.date.period')</a>
        </p>
        <p ng-show="period" class="input-group col-xs-8">
            <input type="text" class="form-control" show-weeks="false" show-button-bar="false" datepicker-popup="dd/MM/yyyy" ng-model="period" min-date="minPeriodDate" is-open="opened"/>
            <span class="input-group-btn">
                <button type="button" class="btn btn-default" ng-click="toggleCalendar($event)"><i class="glyphicon glyphicon-calendar"></i></button>
                <button class="btn btn-default btn-danger" type="button" ng-click="disablePeriod($event)"><span class="fa fa-close"></span></button>
            </span>
        </p>
    </div>
    <div class="col-sm-6 col-lg-7">@lang('view/experience/calendar.info')</div>
</div>
<hr/>
<div class="row">
    <div class="col-sm-6">
        <h2 style="margin-top:0">
            <span ng-show="period">@lang('view/experience/calendar.date.from')&nbsp;</span>
            ${selectedDate|date:'dd/MM/yyyy'}
            <span ng-show="period">&nbsp;@lang('view/experience/calendar.date.to')&nbsp;${period|date:'dd/MM/yyyy'}</span>
        </h2>
    </div>
    <div class="col-sm-6 text-right">
        <button ng-show="events[timestamp] !== false" ng-click="toggleDate(timestamp)" type="button" class="btn btn-danger">
            @lang('view/experience/calendar.available.no')
            <span ng-show="!period">&nbsp;@lang('view/experience/calendar.available.date')</span>
            <span ng-show="period">&nbsp;@lang('view/experience/calendar.available.period')</span>
        </button>
        <button ng-show="events[timestamp] === false" ng-click="toggleDate(timestamp)" type="button" class="btn btn-success">
            @lang('view/experience/calendar.available.yes')
            <span ng-show="!period">&nbsp;@lang('view/experience/calendar.available.date')</span>
            <span ng-show="period">&nbsp;@lang('view/experience/calendar.available.period')</span>
        </button>
    </div>
</div>
<br/>
<br/>
<div class="row">
    <div class="col-sm-2 col-xs-4">@lang('view/experience/calendar.hour.select')</div>
    <div class="col-sm-10 col-xs-8"><timepicker style="margin-top: -35px" ng-model="time" hour-step="1" minute-step="30" show-meridian="false"></timepicker></div>
</div>
<div class="row">
    <div class="col-sm-10 col-sm-offset-2">
        <button ng-disabled="events[timestamp] === false" type="button" class="btn btn-primary" ng-click="addHour(timestamp, time)">
            <span class="fa fa-plus"></span>&nbsp;&nbsp;@lang('view/experience/calendar.hour.add')
        </button>
    </div>
</div>
<br/>
<div class="row">
    <div class="col-sm-2">@lang('view/experience/calendar.hour.selected')</div>
    <div class="col-sm-10">
        <div class="form-control hours-input">
            <span class="label label-info" ng-repeat="time in events[timestamp]">
                ${time| date: 'HH:mm'}&nbsp;
                <span class="delete" ng-click="deleteHour(timestamp, time)">
                    <span class="fa fa-close"></span>
                </span>
            </span>
        </div>
    </div>
</div>
<hr/>
<br/>
<button type="button" class="btn btn-primary" ng-click="save()">Save and quit</button>
<br/>