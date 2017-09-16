/**
 * Created by Marc on 25/05/2015.
 */
(function() {
	var app = angular.module('cbc', ['ui.bootstrap', 'ngAnimate', 'ngTagsInput', 'FileManagement', 'angular-img-cropper', 'cropper', 'uiGmapgoogle-maps', 'tasn']);
	app.config(['$interpolateProvider', 'socialNetworkProvider', function($interpolateProvider, socialNetworkProvider) {
		$interpolateProvider.startSymbol('${');
		$interpolateProvider.endSymbol('}');

		socialNetworkProvider.register('facebook', 'https://www.facebook.com/dialog/oauth', {
			app_id: '299316833598330',
			scope: 'public_profile, email',
			redirect_uri: 'http://cbc.localhost/facebook/signup'
		});
	}]);
})();