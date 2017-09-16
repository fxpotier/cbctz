@extends('layouts.backOffice.base')

@section('scripts')
	@parent
	<script src="{{asset('js/backoffice.js')}}"></script>
@endsection

@section('title')
Translation matching
@endsection

@section('description')
Manage all translation matching of the website
@endsection

@section('body')
	<div class="row" ng-controller="translationCtrl">
		<div class="col-md-3">
			<div class="well">
				<ul class="nav nav-pills nav-stacked">
					@foreach($types as $type => $count)
					<li ng-class="{active:current == '{{$type}}'}" ng-click="select('{{$type}}')"><a>{{$type}} <span class="badge">{{$count}}</span></a></li>
					@endforeach
				</ul>
			</div>
		</div>

		<div class="col-md-9">
			<table class="table table-striped table-hover" ng-if="current && strings.length > 0">
				<thead>
					<tr>
						<th>#</th>
						<th>String</th>
						<th>Language</th>
						<th>Search Matching reference</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					<tr ng-repeat="string in strings">
						<td><strong>${$index}</strong></td>
						<td>${string.field}</td>
						<td>${string.translation[0].language.name}</td>
						<td>
							<input type="text" class="form-control" ng-disabled="string.loading" ng-model="string.matching" placeholder="Search the matching string" typeahead="string.field for string in search($viewValue)"/>
							<span class="text-danger" ng-if="string.error">${string.error}</span>
						</td>
						<td>
							<div class="btn-group">
								<button class="btn btn-default" ng-click="match($index, string, string.matching)" ng-disabled="string.loading">Save</button>
								<button class="btn btn-default" ng-click="match($index, string)" ng-disabled="string.loading">Match self</button>
							</div>
						</td>
					</tr>
				</tbody>
			</table>

			<div class="alert alert-info" ng-if="current && strings.length == 0">
				There is no string to match.
			</div>
		</div>
	</div>
@endsection