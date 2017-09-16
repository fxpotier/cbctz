<div class="row" ng-init="selectedTags={{$search or '[]'}}">
	<div class="col-md-offset-3 col-md-6">
		<div class="row">
			<div class="form-group col-xs-12 col-sm-10 thin-padding">
				<label class="sr-only" for="tags">@lang('view/welcome.header.cities')</label>
				<tags-input id="tags" placeholder="@lang('view/welcome.header.cities')" ng-model="selectedTags" display-property="name" replace-spaces-with-dashes="false" min-length="1">
					<auto-complete load-on-empty="true" load-on-focus="true" select-first-match="false" debounce-delay="300" class="text-left" source="filterTag($query)" min-length="0" max-results-to-show="5"></auto-complete>
				</tags-input>
			</div>
			<div class="col-xs-12 col-sm-2 thin-padding">
				<a href="{{action('SearchController@getSearch')}}/${searchString}" class="btn btn-primary btn-block"><span class="glyphicon glyphicon-search"></span></a>
				{{--<button type="submit" class="btn btn-primary btn-block"><span class="glyphicon glyphicon-search"></span></button>--}}
			</div>
		</div>
	</div>
</div>

