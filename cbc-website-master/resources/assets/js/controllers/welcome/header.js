/**
 * Created by Marc on 10/07/2015.
 */
(function() {
	angular.module('cbc').controller('headerController', ['$scope', '$http', function($scope, $http) {
		$scope.searchString = '';
		$scope.selectedTags = [];
		$scope.tags = [ {name: 'Lyon'}, {name: 'Paris'}, {name: 'Marseille'}, {name: 'Bordeaux'}, {name: 'Lille'}];

		$scope.filterTag = function($query) {
			if($query.replace(/ /g,'')) {
				return $http.get('/tag/find-by-query'+'/'+$query, { cache: true}).then(function(response) {
					var dataObj = response.data;
					return Object.keys(dataObj).map(function (key) {return dataObj[key]});
				});
			}
			else return $scope.tags;
		};

		$scope.$watchCollection('selectedTags', function(newTagCollection) {
			$scope.searchString = '';
			var length = newTagCollection.length;

			for (var i = 0; i < length; i++) {
				$scope.searchString += newTagCollection[i]['name'];
				if(i < length - 1) $scope.searchString += ',';
			}
		});

		$scope.video = false;
		var video = document.getElementById("video");

		$scope.play = function() {
			$scope.video = true;
			var stopping = false;
			var video = document.getElementById("video");
			var duration = video.duration;

			video.setAttribute('controls', '');
			video.play();

			video.addEventListener("timeupdate", function () {
				if (video.currentTime >= duration - 0.5 && !stopping) {
					stopping = true;
					$scope.$apply(function() {
						$scope.stop();
					});
				}
			});
		};

		$scope.stop = function() {
			$scope.video = false;
			video.removeAttribute('controls');
			video.pause();
			setTimeout(function() {
				video.load();
			}, 1750);
		};
	}]);
})();