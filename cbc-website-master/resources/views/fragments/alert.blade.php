<div ng-init="showAlert=true">
	@if(isset($alert))
		<alert ng-show="showAlert" type="{{$errors->count() > 0 ? 'danger' : $alert->type}}" close="showAlert=!showAlert">
			@if(isset($alert->message))
				@lang($alert->message)
			@elseif($errors->count())
				@lang('fragment/utils/alert.error')
			@endif
		</alert>
	@elseif(isset($success))
		<alert ng-show="showAlert" type="success" close="showAlert=!showAlert">@lang($success)</alert>
	@elseif(isset($warning))
		<alert ng-show="showAlert" type="warning" close="showAlert=!showAlert">@lang($warning)</alert>
	@elseif(isset($failure))
		<alert ng-show="showAlert" type="danger" close="showAlert=!showAlert">@lang($failure)</alert>
	@endif
</div>