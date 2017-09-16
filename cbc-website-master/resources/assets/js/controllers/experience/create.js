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