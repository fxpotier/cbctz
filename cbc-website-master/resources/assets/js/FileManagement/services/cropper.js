/**
 * Created by Romain on 14/08/2015.
 */

var resizeMod = angular.module('cropper', []);
resizeMod.factory('$cropper', function() {
	var canvas = angular.element('<canvas></canvas>')[0];
	var context = canvas.getContext('2d');

	var Cropper = function() {
		var self = this;
		this.__callback = angular.noop;
		this.__image = new Image();
		this.__image.onload = function() {
			self.__callback();
		}
	};

	Cropper.prototype = {
		load: function(data, callback) {
			this.__image.src = data;
			this.__callback = callback || angular.noop;
		},
		crop: function(options, callback) {
			var width = this.__image.width;
			var height = this.__image.height;
			var ratio = width/height;

			callback = callback || angular.noop;
			options = angular.extend({
				maxWidth: width,
				maxHeight: height,
				ratio: ratio,
				anchorX: 0.5,
				anchorY: 0.5
			}, options);

			if (ratio < 1) {
				if (width > options.width) width = options.width;
				height = width / options.ratio;
			} else {
				if (height > options.height) height = options.height;
				width = height * options.ratio;
			}

			var x = (this.__image.width - width) * options.anchorX;
			var y = (this.__image.height - height) * options.anchorY;

			canvas.width = width;
			canvas.height = height;
			context.drawImage(this.__image, -x, -y);

			callback(canvas.toDataURL());
		}
	};

	return new Cropper();
});