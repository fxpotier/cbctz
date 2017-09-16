angular.module('cbc').controller('signin', ['$scope', 'socialNetwork', function($scope, socialNetwork) {
	$scope.signin = function(name) {
		socialNetwork.signup(name, {state: $scope.csrf_token}, function() {
			window.location = window.location.origin + '/profile';
		});
	};
}]);
angular.module('cbc').controller('signup', ['$scope', 'socialNetwork', function($scope, socialNetwork) {
	$scope.signup = function(name) {
		socialNetwork.signup(name, {state: $scope.csrf_token}, function() {
			window.location = window.location.origin + '/profile';
		});
	};
}]);