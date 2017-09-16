/**
 * Created by Marc on 10/07/2015.
 */

(function() {
	angular.module('cbc').controller('IndexController', ['$scope', '$http', '$modal', function($scope, $http, $modal) {

		$scope.feedback = function(id, role) {
			var modalInstance = $modal.open({
				animation: true,
				templateUrl: 'modalFeedback.html',
				controller: 'ModalFeedbackController',
				size: 'lg',
				resolve: {
					id: function () {
						return id;
					},
					role: function () {
						return role;
					}
				}
			});

			modalInstance.result.then(function () {
				$http.post('/user/bookings/state/' + id)
					.success(function() {
						location.reload();
					}
				);
			});
		};

		$scope.signal = function(id, role) {
			$http.post('/user/bookings/signal/'+id+'/'+role)
				.success(function() {
					location.reload();
				}
			);
		};

		$scope.changeState = function (title, date, persons, id, state, role) {
			var modalInstance = $modal.open({
				animation: true,
				templateUrl: 'modalBooking.html',
				controller: 'ModalBookingController',
				size: 'md',
				resolve: {
					state: function () {
						return state;
					},
					title: function () {
						return title;
					},
					date: function () {
						return date;
					},
					persons: function () {
						return persons;
					}
				}
			});

			modalInstance.result.then(function () {
				$http.post('/user/bookings/state/' + id + '/' + state + '/' + role)
					.success(function() {
						location.reload();
					}
				);
			});
		};
	}]);

	angular.module('cbc').controller('ModalBookingController', function ($scope, $modalInstance, state, title, date, persons) {
		$scope.state = state;
		$scope.title = title;
		$scope.date = Date.parse(date);
		$scope.persons = persons;

		$scope.ok = function () {
			$modalInstance.close();
		};
		$scope.cancel = function () {
			$modalInstance.dismiss('cancel');
		};
	});

	angular.module('cbc').controller('ModalFeedbackController', function ($scope, $modalInstance, id, role) {
		$scope.role = role;
		$scope.id = id;

		$scope.ok = function () {
			$modalInstance.close();
		};
		$scope.cancel = function () {
			$modalInstance.dismiss('cancel');
		};
	});

})();