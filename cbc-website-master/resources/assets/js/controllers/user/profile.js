/**
 * Created by Marc on 25/05/2015.
 */
(function() {
	angular.module('cbc').controller('ProfileController', ['$scope', function($scope) {

		$scope.checkMismatch = function() {
			if(!$scope.mainLanguage) $scope.mainLanguage = 'English';
			var mainLanguage = $scope.mainLanguage.name||$scope.mainLanguage;
			for (var i = 0; i < $scope.spokenLanguages.length; i++) {
				if(($scope.spokenLanguages[i].name||$scope.spokenLanguages[i]) == mainLanguage) $scope.spokenLanguages.splice(i, 1);
			}
		};

		$scope.filterLanguage = function($query) {
			return $scope.languages.filter(function(language) {
				if(language.name == ($scope.mainLanguage.name||$scope.mainLanguage)) return;
				return language.name.toLowerCase().indexOf($query.toLowerCase()) != -1;
			});
		}
	}]);
})();