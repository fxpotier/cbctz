var SocialNetwork = function(networks) {
	this.__networks = networks;
};

SocialNetwork.prototype = {
	signup: function(networkName, options, callback) {
		var network = this.__networks[networkName];
		if (network == null) {
			console.error('"' + networkName + '" not registered in the social network manager.');
			return;
		}

		options = angular.extend({}, network.params || {}, options || {});
		var uri = network.uri;

		var params = [];
		for (var p in options) {
			if (!options.hasOwnProperty(p)) continue;
			params.push(p + '=' + encodeURIComponent(options[p]));
		}
		uri += '?' + params.join('&');

		var w = window.open(uri, '_blank');
		w.onload = function() {
			var content = w.document.documentElement.textContent;
			w.close();
			if (callback) callback(content);
		};
	}
};

angular.module('tasn', []).provider('socialNetwork', function() {
	var networks = {};

	this.register = function(name, uri, params) {
		if (networks[name] != undefined) {
			console.error('"' + name +'" social network already register into the provider.');
			return;
		}

		networks[name] = {
			uri: uri,
			params: params
		};
	};

	this.$get = function() {
		return new SocialNetwork(networks);
	};
});