/**
 * Created by Marc on 03/08/2015.
 */
(function() {
	angular.module('cbc').controller('CalendarController', ['$scope', '$http', 'calendar', function($scope, $http, calendar) {
		$scope.period = false;
		$scope.minDate = new Date();
		$scope.minPeriodDate = new Date();
		$scope.time = new Date().setHours(12, 0, 0, 0);
		$scope.timestamp = Math.floor($scope.selectedDate / 1000);
		$scope.events = {};
		$scope.opened = true;

		var now = new Date();
		var offset = (now.getHours() - now.getUTCHours()) * 3600;

		$scope.$watch('slug', function() {
			if ($scope.slug == null) return;
			$http.get(calendar.getEvents + $scope.slug + '/' + offset)
				.success(function(data) {
					$scope.events = data;
					$scope.selectedDate = new Date();
					$scope.selectedDate.setHours(0, 0, 0, 0);
				}
			);
		});

		$scope.save = function() {
			var now = new Date();
			var offset = now.getHours() - now.getUTCHours();
			var events = angular.extend({}, $scope.events);
			$http.post(calendar.postEvents + $scope.slug, {events: events, offset:offset})
				.success(function() { window.location = calendar.redirect; }
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
			if(!isNaN(date)) date = new Date(date*1000);
			if(!isNaN(hour)) hour = new Date(hour);

			hour.setFullYear(date.getFullYear(), date.getMonth(), date.getDate());

			date = date.getTime()/1000;
			hour = hour.getTime();

			safeObject($scope.events, date, []);
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

		};

		$scope.toggleCalendar = function($event) {
			$event.stopPropagation();
			$scope.opened = !$scope.opened;
		};

		$scope.getDayClass = function(date) {
			var dayToCheck = new Date(date);
			dayToCheck.setHours(0,0,0,0);
			dayToCheck = Math.floor(dayToCheck.getTime() / 1000).toString();

			var event = $scope.events[dayToCheck];
			if (event) return 'has-hours';
			else if (event != null) return 'not-available';
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
			if(!newVal) return;
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
	angular.module('cbc').controller('CreateController', ['$scope', '$cropper', '$http', '$modal', function($scope, $cropper, $http, $modal) {
		$scope.add = false;
		$scope.languages = [];
		$scope.cities = [];
		$scope.url = '';
		$scope.main = [];

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

		$scope.delete = function(slug) {
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