(function() {
	var module = angular.module('FileManagement', []);

	module.directive('fileModel', function() {
		return {
			restrict: 'A',
			scope: {
				fileModel: '=',
				fileChange: '&'
			},
			link: function(scope, element) {
				scope.fileModel = [];

				element.bind('change', function() {
					for (var i = 0; i < element[0].files.length; i++) {
						var file = element[0].files[i];
						var fileData = {
							file: file,
							name: file.name,
							size: file.size,
							type: file.type,
							date: file.lastModifiedDate
						};

						var reader = new FileReader();
						reader.readAsDataURL(file);
						reader.onloadend = (function(fileData, reader) {
							return function() {
								fileData.data = reader.result;
								scope.$apply(function() {
									scope.fileModel.push(fileData);
								});
							}
						})(fileData, reader);
					}
					element[0].value = '';

					setTimeout(function() {
						scope.fileChange();
					}, 100);

				});
			}
		};
	});
})();