<div class="form-group row">
    <label for="display_language" class="col-md-2 control-label">@lang('fragment/form/language.input.display_language')</label>
    <div class="col-md-10">
        <select name="displayLanguage" id="display_language" ng-options="language as language.name for language in displayLanguages track by language.id" ng-model="displayLanguage" class="form-control"></select>
        <p class="help-block">@lang('fragment/form/language.help.display_language')</p>
    </div>
</div>
<div class="form-group row">
    <label for="main_language" class="col-md-2 control-label">@lang('fragment/form/language.input.main_language')</label>
    <div class="col-md-10">
        <input name="mainLanguage" id="main_language" type="text" ng-model="mainLanguage" placeholder="@lang('fragment/form/language.input.main_language')" typeahead="language as language.name for language in languages | filter:{name:$viewValue}" ng-blur="checkMismatch()" class="form-control">
        <p class="help-block">@lang('fragment/form/language.help.main_language')</p>
    </div>
</div>
<div class="form-group row">
    <label for="languages" class="col-md-2 control-label">@lang('fragment/form/language.input.languages')</label>
    <div class="col-md-10">
        <tags-input ng-blur="checkMismatch()" id="languages" placeholder="@lang('fragment/form/language.input.languages')" ng-model="spokenLanguages" display-property="name" replace-spaces-with-dashes="false" min-length="1">
            <auto-complete source="filterLanguage($query)" min-length="0" max-results-to-show="5"></auto-complete>
        </tags-input>
        <p class="help-block">@lang('fragment/form/language.help.languages')</p>
    </div>
</div>
<input name="spokenLanguages[]" ng-repeat="language in spokenLanguages" type="hidden" ng-value="language.name||language"/>
<div class="form-group row">
    <label for="description_${mainLanguage.name||mainLanguage}" class="col-md-2 control-label">@lang('fragment/form/language.input.description')<br/>(${mainLanguage.name||mainLanguage})</label>
    <div class="col-md-10">
        <input type="hidden" name="descriptionRef[0][language]" value="${mainLanguage.name||mainLanguage}" />
        <textarea name="descriptionRef[0][content]" class="form-control" rows="6" id="description_${mainLanguage.name||mainLanguage}" placeholder="@lang('fragment/form/language.input.description') (${mainLanguage.name||mainLanguage})">${descriptions[mainLanguage.alias].content}</textarea>
        <p class="help-block">@lang('fragment/form/language.help.description')</p>
    </div>
</div>
<div class="form-group row" ng-repeat="language in spokenLanguages track by $index">
    <label for="description_${language.name||language}" class="col-md-2 control-label">@lang('fragment/form/language.input.description')<br/>(${language.name||language})</label>
    <div class="col-md-10">
        <input type="hidden" name="descriptions[${$index}][language]" value="${language.name||language}" />
        <textarea name="descriptions[${$index}][content]" class="form-control" rows="6" id="description_${language.name||language}" placeholder="@lang('fragment/form/language.input.description') (${language.name||language})">${descriptions[language.alias].content}</textarea>
        <p class="help-block">@lang('fragment/form/language.help.description')</p>
    </div>
</div>