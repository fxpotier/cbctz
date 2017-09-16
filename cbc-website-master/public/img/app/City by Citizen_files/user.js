/**
 * Created by Hinomi on 27/05/2015.
 */
angular.module('cbc').controller('experienceCtrl', function() {
});
/**
 * Created by Marc on 25/05/2015.
 */
(function() {
	angular.module('cbc').controller('PictureController', ['$scope', '$modal', function($scope, $modal) {
		$scope.delete = function(pictures, index) {
			index = typeof index !== 'undefined' ? index : 0;
			pictures.splice(index, 1);
		};

		$scope.open = function(picture, width, height, cropped, display) {
			var modalInstance = $modal.open({
				animation: true,
				templateUrl: 'myModalContent.html',
				controller: 'ModalInstanceCtrl',
				size: 'lg',
				resolve: {
					picture: function () { return picture; },
					width: function () { return width; },
					height: function () { return height; },
					display: function () { return display; }
				}
			});
		};
	}]);

	angular.module('cbc').controller('ModalInstanceCtrl', function ($scope, $modalInstance, picture, width, height, display) {
		$scope.picture = picture;
		$scope.width = width;
		$scope.height = height;
		$scope.display = display;

		$scope.ok = function () {
			$modalInstance.close();
		};
		$scope.cancel = function () {
			$modalInstance.dismiss('cancel');
		};
	});
})();

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