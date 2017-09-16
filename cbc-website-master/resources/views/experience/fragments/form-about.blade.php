<div class="form-group row has-feedback {{$errors->first('title') ? 'has-error' : ''}}">
    <label for="title" class="col-md-2 control-label">@lang('view/experience/create.about.input.title')<br/>({{$user->mainLanguage->name}})</label>
    <div class="col-md-10">
        <input name="title" type="text" class="form-control" id="title" placeholder="@lang('view/experience/create.about.input.title')" required value="{{$experience->description->title or Session::get('inputs')['title']}}">
        <p class="help-block">@lang('view/experience/create.about.help.title')</p>
        <p class="help-block text-error">@lang($errors->first('title'))</p>
    </div>
</div>
<div class="form-group row has-feedback {{$errors->first('content') ? 'has-error' : ''}}">
    <label for="content" class="col-md-2 control-label">@lang('view/experience/create.about.input.content')<br/>({{$user->mainLanguage->name}})</label>
    <div class="col-md-10">
        <textarea class="form-control" rows="6" name="content" id="content" placeholder="@lang('view/experience/create.about.input.content')" required>{{$experience->description->content or Session::get('inputs')['content']}}</textarea>
        <p class="help-block">@lang('view/experience/create.about.help.content')</p>
        <p class="help-block text-error">@lang($errors->first('content'))</p>
    </div>
</div>
<div class="form-group row" ng-init='translations={{$translations or '[]'}}'>
    <label for="languages" class="col-md-2 control-label">@lang('view/experience/create.about.input.languages')</label>
    <div class="col-md-10">
        <tags-input id="languages" placeholder="@lang('view/experience/create.about.input.language-add')" ng-model="translations" display-property="name" replace-spaces-with-dashes="false" min-length="1">
            <auto-complete debounce-delay="250" min-length="0" load-on-empty="true" source="getLanguages($query)" min-length="0" max-results-to-show="5"></auto-complete>
        </tags-input>
        <input name="translations[]" ng-repeat="language in translations" type="hidden" ng-value="language.name||language"/>
        <p class="help-block">@lang('view/experience/create.about.help.languages')</p>
    </div>
</div>
<div ng-init='descriptions={{$descriptions or '[]'}}'>
    <div ng-repeat="language in translations track by $index">
        <div class="form-group row">
            <label for="title_${language.name||language}" class="col-md-2 control-label">@lang('view/experience/create.about.input.title-translate')<br/>(${language.name||language})</label>
            <div class="col-md-10">
                <input name="descriptions[${language.name}][title]" type="text" class="form-control" id="title_${language.name||language" placeholder="@lang('view/experience/create.about.input.title-translate') (${language.name||language})" required ng-value="descriptions[language.name].title">
            </div>
        </div>
        <div class="form-group row">
            <label for="description_${language.name||language}" class="col-md-2 control-label">@lang('view/experience/create.about.input.description-translate')<br/>(${language.name||language})</label>
            <div class="col-md-10">
                <textarea name="descriptions[${language.name}][content]" class="form-control" rows="6" id="description_${language.name||language}" placeholder="@lang('view/experience/create.about.input.description-translate') (${language.name||language})" required>${descriptions[language.name].content}</textarea>
            </div>
        </div>
    </div>
</div>
<div class="form-group row" ng-init='tags={{$tags or '[]'}}'>
    <label for="tag" class="col-md-2 control-label">@lang('view/experience/create.about.input.tags')</label>
    <div class="col-md-10">
        <tags-input id="tags" placeholder="@lang('view/experience/create.about.input.tags-add')" ng-model="tags" display-property="name" replace-spaces-with-dashes="false" min-length="1"></tags-input>
        <input name="tags[]" ng-repeat="tag in tags" type="hidden" ng-value="tag.name||tag"/>
        <p class="help-block">@lang('view/experience/create.about.help.tags')</p>
    </div>
</div>
<div class="form-group row">
    <label for="transportation" class="col-md-2 control-label">@lang('view/experience/create.about.input.transportation')</label>
    <div class="col-md-10">
        <tags-input id="transportation" placeholder="@lang('view/experience/create.about.input.transportation-add')" ng-model="transportation" display-property="name" replace-spaces-with-dashes="false" min-length="1">
            {{--<auto-complete debounce-delay="250" min-length="0" source="transportations($query)" min-length="0" max-results-to-show="5"></auto-complete>--}}
        </tags-input>
        <input name="transportation[]" ng-repeat="item in transportation" type="hidden" ng-value="item.name||item"/>
        <p class="help-block">@lang('view/experience/create.about.help.transportation')</p>
    </div>
</div>