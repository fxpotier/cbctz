@include('fragments.experience')
<div class="panel-footer">
    <div class="row thin-padding-bottom">
        <div class="col-xs-6 thin-padding-right">
            <a href="{{action('ExperienceController@getEdit', $experience->slugName)}}" class="btn btn-primary btn-block">@lang('view/experience/create.edit-experience')</a>
        </div>
        <div class="col-xs-6 thin-padding-left">
            <a href="{{action('ExperienceController@getCalendar', $experience->slugName)}}" class="btn btn-primary btn-block">@lang('view/experience/create.edit-calendar')</a>
        </div>
    </div>
    @if($state == 'online' || $state == 'offline')
    <?php $state = $state == 'online' ? 'offline' : 'online' ?>
    <button class="btn btn-block btn-primary" ng-click="changeState('{{$experience->slugName}}', '{{$state}}')">@lang('view/experience/create.put') @lang('view/experience/create.state.'.$state)</button>
    @endif
    <button class="btn btn-block btn-danger" ng-click="delete('{{$experience->slugName}}')">@lang('view/experience/create.delete')</button>
</div>