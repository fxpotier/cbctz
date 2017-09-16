/**
 * Created by Hinomi on 29/05/2015.
 */
angular.module('cbc').controller('translationCtrl', ['$scope', '$http', function($scope, $http) {
	$scope.current = null;
	$scope.strings = [];
	$scope.nexts = [];

	var nextOffset;

	$scope.select = function(type) {
		$http.get(window.location.origin + window.location.pathname + '/unmatched/' + type).success(function(data) {
			$scope.current = type;
			$scope.strings = data;
			nextOffset = data.length;
			loadNexts();
		});
	};

	$scope.search = function(search) {
		if (!search) return;
		return $http.get(window.location.origin + window.location.pathname + '/matching/' + $scope.current + '/' + search).then(function(response) {
			return response.data;
		});
	};

	$scope.match = function(i, string, matching) {
		string.loading = true;
		$http.get(window.location.origin + window.location.pathname + '/match/' + $scope.current + '/' + string.id + (matching ? '/' + matching : '')).success(function() {
			$scope.strings.splice(i, 1);
			nextOffset--;

			if ($scope.nexts.length > 0) {
				$scope.strings.push($scope.nexts[0]);
				$scope.nexts.splice(0, 1);
				if ($scope.nexts.length == 0) loadNexts();
			}
		}).error(function(data) {
			$scope.$watch(function() {
				string.error = data;
				string.loading = false;
			});
		});
	};

	var loadNexts = function() {
		if (nextOffset == -1) return;
		$http.get(window.location.origin + window.location.pathname + '/unmatched/' + $scope.current + '/' + nextOffset).success(function(data) {
			$scope.nexts = data;
			if (data.length == 0) nextOffset = -1;
			else nextOffset += data.length;
		});
	};
}]);
/**
 * Created by Hinomi on 28/05/2015.
 */
angular.module('cbc').controller('validatorCtrl', ['$scope', '$http', function($scope, $http) {
	$scope.current = null;
	$scope.rulesList = {};

	$scope.ruleTypes = [
		{name: "Accepted", rule: "accepted"},
		{name: "Active URL", rule: "active_url"},
		{name: "After date", rule: "after", params: ["Reference date"]},
		{name: "Alpha", rule: "alpha"},
		{name: "Alpha dash", rule: "alpha_dash"},
		{name: "Alpha numeric", rule: "alpha_num"},
		{name: "Array", rule: "array"},
		{name: "Before date", rule: "before", params: ["Reference date"]},
		{name: "Boolean", rule: "boolean"},
		{name: "Confirmed", rule: "confirmed"},
		{name: "Date", rule: "date"},
		{name: "Date Format", rule: "date_format", params: ["Date format"]},
		{name: "Different", rule: "different", params: ["Field name"]},
		{name: "Digits", rule: "digits", params: ["Length"]},
		{name: "Digits interval", rule: "digits_between", params: ["Minimum", "Maximum"]},
		{name: "E-mail", rule: "email"},
		{name: "Exists in database", rule: "exists", params: ["Table name", "Column name (leave blank to use the field name)"]},
		{name: "Image", rule: "image"},
		{name: "In values list", rule: "in", params: ["Values (Separated by a comma)"]},
		{name: "Integer", rule: "integer"},
		{name: "Ip address", rule: "ip"},
		{name: "Number interval", rule: "between", params: ["Minimum", "Maximum"]},
		{name: "Maximum value", rule: "max", params: ["Maximum value"]},
		{name: "Mime types", rule: "mimes", params: ["Types (Separated by a comma)"]},
		{name: "Minimum value", rule: "min",  params: ["Minimum value"]},
		{name: "Not in values list", rule: "not_in", params: ["Values (Separated by a comma)"]},
		{name: "Numeric", rule: "numeric"},
		{name: "Regular expression", rule: "regex", params: ["Pattern"]},
		{name: "Required", rule: "required"},
		{name: "Required if", rule: "required_if", params: ["Field name", "Values list"]},
		{name: "Required with", rule: "required_with", params: ["Fields list"]},
		{name: "Required with all", rule: "required_with_all", params: ["Fields list"]},
		{name: "Required without", rule: "required_without", params: ["Fields list"]},
		{name: "Required without all", rule: "required_without_all", params: ["Fields list"]},
		{name: "Same as", rule: "same", params: ["Field name"]},
		{name: "Size", rule: "size", params: ["Size"]},
		{name: "String", rule: "string"},
		{name: "Timezone", rule: "timezone"},
		{name: "Unique in database", rule: "unique", params: ["Table name", "Column name (leave blank to use the field name)"]},
		{name: "URL", rule: "url"}
	];

	$scope.select = function(name) {
		$scope.current = name;

		$http.get(window.location.origin + window.location.pathname + '/rules/' + name).success(function(data) {
			$scope.rulesList = data;

			for (var field in $scope.rulesList) {
				var rulesString = $scope.rulesList[field];
				$scope.rulesList[field] = rulesString ? rulesString.split('|') : [];
			}
		});
	};

	$scope.addRule = function(field, ruleType) {
		var rule = ruleType.rule;
		if (ruleType.params) {
			var params = [];
			for (var p in ruleType.params) {
				var value = prompt(ruleType.params[p]);
				if (value) params.push(value.trim());
			}

			if (params.length > 0) rule += ':' + params.join(',');
		}

		$scope.rulesList[field].push(rule);
		save();
	};

	$scope.removeRule = function(field, id) {
		$scope.rulesList[field].splice(id, 1);
		save();
	};

	var save = function() {
		var rules = {};
		for (var field in $scope.rulesList)
			rules[field] = $scope.rulesList[field].join('|');

		$http.post(window.location.origin + window.location.pathname + '/save/' + $scope.current, rules);
	};
}]);