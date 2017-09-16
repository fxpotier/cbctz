/**
 * Created by Marc on 03/08/2015.
 */
(function() {
	angular.module('cbc').controller('CalendarController', ['$scope', '$http', function($scope, $http) {
		$scope.slug = '';
		$scope.period = false;
		$scope.minDate = new Date();
		$scope.minPeriodDate = new Date();
		$scope.time = new Date().setHours(12, 0, 0, 0);
		$scope.selectedDate = new Date();
		$scope.selectedDate.setHours(0, 0, 0, 0);
		$scope.timestamp = Math.floor($scope.selectedDate / 1000);
		$scope.events = {};
		$scope.opened = true;
		$scope.redirect = '';
		$scope.post = '';

		var now = new Date();
		var offset = (now.getHours() - now.getUTCHours()) * 3600;
		var stopWatch = $scope.$watch('events', function() {
			stopWatch();

			for (var key in $scope.events) {
				if (!$scope.events.hasOwnProperty(key)) continue;
				var day = $scope.events[key];
				delete $scope.events[key];
				$scope.events[Number.parseInt(key) - offset] = day;
			}
		});

		$scope.save = function() {
			var now = new Date();
			var offset = now.getHours() - now.getUTCHours();
			var events = angular.extend({}, $scope.events);

			$http.post($scope.post + $scope.slug, {events: events, offset:offset})
				.success(function() { window.location = $scope.redirect; }
			);
		};

		function BatchCalendarActions(callback, date, hour) {
			if($scope.period) {
				var endDate = $scope.period;
				if(endDate instanceof Date) endDate = endDate.getTime();
				endDate = Math.floor(endDate / 1000);
				for (var currentDate = date; currentDate <= endDate; currentDate = Tomorrow(currentDate)) {
					callback(currentDate, hour);
				}
			}
			else callback(date, hour);

			var d = new Date($scope.selectedDate);
			if (d.getMilliseconds() == 0) $scope.selectedDate++;
			else $scope.selectedDate--;
		}

		$scope.addHour = function(date, hour) {
			BatchCalendarActions(AddHour, date, hour);
		};

		function AddHour(date, hour) {
			if(date instanceof Date) date = date.getTime();
			safeObject($scope.events, date, []);
			if(hour instanceof Date) hour = hour.getTime();
			if(!$scope.events[date]) return;
			if($scope.events[date].indexOf(hour) == -1) $scope.events[date].push(hour);
		}

		$scope.deleteHour = function(date, hour) {
			BatchCalendarActions(DeleteHour, date, hour);
		};

		function DeleteHour(date, hour) {
			if(!$scope.events[date]) return;
			var index = $scope.events[date].indexOf(hour);
			if(index > -1) $scope.events[date].splice(index, 1);
			if($scope.events[date].length == 0) delete $scope.events[date];
		}

		$scope.toggleDate = function(date) {
			BatchCalendarActions(ToggleDate, date, null);
		};

		function ToggleDate(date, hour) {
			if($scope.events[date] === false) delete $scope.events[date];
			else {
				safeObject($scope.events, date, []);
				$scope.events[date] = false;
			}
		}

		$scope.enablePeriod = function(date, $event) {
			$scope.period = Tomorrow(date/1000)*1000;
			$scope.minPeriodDate = $scope.period;

			$event.stopPropagation();
			$scope.opened = true;
		};

		$scope.disablePeriod = function($event) {

			$scope.opened = false;

			$scope.period = false;

			// $event.stopPropagation();

		};

		$scope.toggleCalendar = function($event) {
			$event.stopPropagation();
			$scope.opened = !$scope.opened;
		};

		$scope.getDayClass = function(date) {
			var dayToCheck = new Date(date);
			dayToCheck.setHours(0,0,0,0);
			dayToCheck = Math.floor(dayToCheck.getTime() / 1000).toString();

			for (var event in $scope.events) {
				if(!$scope.events.hasOwnProperty(event)) continue;
				if (dayToCheck === event) {
					if($scope.events[event]) return 'has-hours';
					else if($scope.events[event] != null) return 'not-available';
				}
			}
		};

		$scope.disabled = function(date) {
			var dayToCheck = new Date(date);
			dayToCheck.setHours(0,0,0,0);
			dayToCheck = Math.floor(dayToCheck.getTime() / 1000).toString();
			for (var event in $scope.events) {
				if(!$scope.events.hasOwnProperty(event)) continue;
				if (dayToCheck === event) {
					if($scope.events[event] == null) return true;
				}
			}
		};

		function safeObject(object, key, data) {
			if(!object.hasOwnProperty(key)) $scope.events[key] = data;
		}

		function Tomorrow(date) {
			return date + 86400;
		}

		$scope.$watch('selectedDate', function(newVal) {
			if(!Number.isInteger(newVal)) $scope.selectedDate = newVal.getTime();
			if($scope.period) $scope.period = false;
			$scope.timestamp = Math.floor($scope.selectedDate /1000);
		}, true);
	}]);
})();
/**
 * Created by Marc on 12/07/2015.
 */
(function() {
	angular.module('cbc').controller('CreateController', ['$scope', '$http', '$modal', function($scope, $http, $modal) {
		$scope.add = false;
		$scope.languages = [];
		$scope.cities = [];
		$scope.url = '';

		$scope.getLanguages = function(query) {
			if(query.replace(/ /g,'')) {
				return $http.get('/language/find-by-query'+'/'+query, { cache: true}).then(function(response) {
					var dataObj = response.data;
					return Object.keys(dataObj).map(function (key) {return dataObj[key]});
				});
			}
			else return [];
		};

		$scope.getCities = function(query){
			return $scope.cities;
		};

		$scope.changeState = function(slug, state) {
			$http.post($scope.url + 'state/' + slug, {state: state})
				.success(function() { location.reload(); }
			);
		};

		$scope.delete = function (slug) {
			var modalInstance = $modal.open({
				templateUrl: 'deleteModal.html',
				controller: 'DeleteModalController',
				size: 'sm'
			});

			modalInstance.result.then(function () {
				$http.post($scope.url + 'delete/' + slug)
					.success(function() { location.reload(); }
				);
			});
		};
	}]);

	angular.module('cbc').controller('DeleteModalController', function ($scope, $modalInstance) {
		$scope.validate = function () {
			$modalInstance.close();
		};

		$scope.cancel = function () {
			$modalInstance.dismiss('cancel');
		};
	});

})();
/**
 * Created by Marc on 30/06/2015.
 */
(function() {
	angular.module('cbc').controller('ShowController', ['$scope', '$filter', function($scope, $filter) {
		$scope.isDayAuto = false;
		$scope.minDate = new Date();
		$scope.date = new Date();
		$scope.date.setHours(12, 0, 0, 0);
		$scope.date = $scope.date.toISOString();

		$scope.hours = [];

		$scope.zoomFromRadius = function(radius) {
			return Math.round(-(1.4427*Math.log(radius)-3.2877-21));
		};

		$scope.disabled = function(date, mode) {
			if (mode === 'day') {
				var result =  checkDateInDays(date, $scope.events.never, true);
				if(result) return result;
			}
		};

		$scope.getDayClass = function(date, mode) {
			if (mode === 'day') {
				var auto = Object.keys($scope.events.auto);
				var result =  checkDateInDays(date, auto, 'auto');
				if(result) return result;
			}
		};

		$scope.$watch('date', function(newValue) {
			$scope.isDayAuto = false;
			var auto = Object.keys($scope.events.auto);
			checkDateInDays(newValue, auto, function() { $scope.isDayAuto = true; });
			if($scope.isDayAuto) $scope.hours = $scope.events.auto[$filter('date')(newValue, 'M dd yyyy')];
		});

		function checkDateInDays(date, days, success_value) {
			var dayToCheck = new Date(date).setHours(0, 0, 0, 0);
			for (var i in days) {
				var currentDay = new Date(days[i]).setHours(0, 0, 0, 0);
				if (dayToCheck === currentDay) {
					if (typeof success_value == 'function') return success_value();
					else return success_value;
				}
			}
		}
	}]);
})();