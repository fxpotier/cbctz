/**
 * Created by Marc on 30/06/2015.
 */
(function() {
	angular.module('cbc').controller('ShowController', ['$scope', '$http', 'calendar', function($scope, $http, calendar) {
		var now = new Date();
		$scope.now = now;
		$scope.initial = $scope.now.setHours($scope.now.getHours()+1, 0, 0, 0);
		$scope.selectedHour = $scope.initial;
		$scope.dateToSend = $scope.initial;
		$scope.date = $scope.now.getTime();
		$scope.hours = null;

		var offset = (now.getHours() - now.getUTCHours()) * 3600;

		$scope.zoomFromRadius = function(radius) {
			return Math.round(-(1.4427*Math.log(radius)-3.2877-21));
		};

		$scope.$watch('slug', function() {
			if ($scope.slug == null) return;
			$http.get(calendar.getEvents + $scope.slug + '/' + offset)
				.success(function(data) {
					$scope.events = data;
					$scope.date = $scope.now;
					$scope.date.setHours(0, 0, 0, 0);
				}
			);
		});

		$scope.getDayClass = function(date) {
			if(!$scope.events) return;
			var dayToCheck = new Date(date);
			dayToCheck.setHours(0,0,0,0);
			dayToCheck = Math.floor(dayToCheck.getTime() / 1000).toString();
			if ($scope.events[dayToCheck]) return 'has-hours';
		};

		$scope.disabled = function(date) {
			if(!$scope.events) return;
			var dayToCheck = new Date(date);
			dayToCheck.setHours(0,0,0,0);
			dayToCheck = Math.floor(dayToCheck.getTime() / 1000).toString();
			return $scope.events[dayToCheck] === false;
		};

		$scope.$watch('date', function(newVal) {
			if(!newVal || !$scope.events) return;
			if(!Number.isInteger(newVal)) $scope.date = newVal.getTime();

			var selectedDate = new Date(newVal);
			var date = new Date($scope.dateToSend);
			date.setFullYear(selectedDate.getFullYear(), selectedDate.getMonth(), selectedDate.getDate());
			$scope.dateToSend = date.getTime();

			$scope.hours = ($scope.events[$scope.date/1000]) || null;
			if($scope.hours) {
				$scope.hours.sort();
				$scope.selectedHour = $scope.hours[0];
			}
		}, true);

		$scope.$watch('selectedTextHour', function(newVal) {
			if(!newVal) return;
			$scope.selectedHour = parseInt(newVal);
		}, true);

		$scope.$watch('selectedHour', function(newVal) {
			if(!newVal) return;
			var selectedHour = new Date(newVal);
			var date = new Date($scope.dateToSend);
			date.setHours(selectedHour.getHours(), selectedHour.getMinutes());
			$scope.dateToSend = date.getTime();
		}, true);
	}]);
})();