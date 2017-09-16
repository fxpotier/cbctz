@extends('layouts.backOffice.base')

@section('scripts')
	@parent
	<script src="{{asset('js/backoffice.js')}}"></script>
@endsection

@section('title')
Validation rules
@endsection

@section('description')
Manage all validation rules of the website
@endsection

@section('body')
	<div class="row" ng-controller="validatorCtrl" ng-init="select('{{$list[0]}}')">
		<div class="col-md-3">
			<div class="well">
				<ul class="nav nav-pills nav-stacked">
					@foreach($list as $name)
					<li ng-class="{active:current == '{{$name}}' }" ng-click="select('{{$name}}')"><a href="#">{{$name}}</a></li>
					@endforeach
				</ul>
			</div>
		</div>

		<div class="col-md-9">
			<div class="list-group">
				<div class="list-group-item" ng-repeat="(field, rules) in rulesList">
					<strong>${field}</strong><br/>

					<button class="btn btn-default" ng-repeat="rule in rules" ng-click="removeRule(field, $index)">
						${rule}
						<span class="glyphicon glyphicon-remove"></span>
					</button>

					<div class="dropdown" dropdown>
						<button class="btn btn-default dropdown-toggle" dropdown-toggle>
							Add a new rule <span class="caret"></span>
						</button>
						<ul class="dropdown-menu">
							<li ng-repeat="type in ruleTypes" ng-click="addRule(field, type)"><a>${type.name}</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection