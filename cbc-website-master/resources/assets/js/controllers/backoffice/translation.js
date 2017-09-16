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