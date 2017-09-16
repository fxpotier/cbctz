angular.module('cbc').controller('signin', ['$scope', 'socialNetwork', function($scope, socialNetwork) {
	$scope.signin = function(name) {
		socialNetwork.signup(name, {state: $scope.csrf_token}, function() {
			window.location = window.location.origin + '/profile';
		});
	};
}]);