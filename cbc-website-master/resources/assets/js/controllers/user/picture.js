/**
 * Created by Marc on 25/05/2015.
 */
(function() {
	angular.module('cbc').controller('PictureController', ['$scope', '$cropper', '$modal', function($scope, $cropper, $modal) {
		$scope.delete = function(pictures, index) {
			index = typeof index !== 'undefined' ? index : 0;
			pictures.splice(index, 1);
		};

		$scope.crop = function(img, width, height) {
			$cropper.load(img[img.length-1].data, function() {
				$cropper.crop({
					width: width,
					height: height
				}, function(cropped) {
					$scope.$apply(function() {
						img[img.length-1].cropped = cropped;
					});
				})
			});
		};

		$scope.copy = function(img, dest, width, height) {
			var copy = angular.copy(img);
			setTimeout(function(){
				$cropper.load(copy[copy.length-1].data, function() {
					$cropper.crop({
						width: width,
						height: height
					}, function(cropped) {
						$scope.$apply(function() {
							copy[copy.length-1].cropped = cropped;
							dest.push(copy[copy.length-1]);
						});
					})
				});
			}, 0);
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

			modalInstance.result.then(function (cropped) {
				picture.cropped = cropped;
			});
		};
	}]);

	angular.module('cbc').controller('ModalInstanceCtrl', function ($scope, $modalInstance, picture, width, height, display) {
		$scope.width = width;
		$scope.height = height;
		$scope.display = display;

		$scope.picture = {};
		$scope.picture.data = null;
		$scope.picture.cropped = null;

		setTimeout(function() {
			$scope.picture.data = picture.data;
			$scope.picture.cropped = picture.cropped;
		}, 0);

		$scope.ok = function () {
			$modalInstance.close($scope.picture.cropped);
		};

		$scope.cancel = function () {
			$modalInstance.dismiss('cancel');
		};
	});
})();
