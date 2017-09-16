var elixir = require('laravel-elixir');
var gulp = require('gulp');
var path = require('path');
var concat = require('gulp-concat');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Less
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
	mix.less([
		'app/app.less',
		'app/pages/welcome/welcome.less',
		'app/pages/user/user.less',
		'app/pages/experience/experience.less',
		'app/pages/booking/booking.less',
		'app/pages/profile/profile.less',
		'app/pages/pages/pages.less',
		'bootstrap/bootstrap.less',
		'font-awesome/font-awesome.less',
		'ng-tags-input/ng-tags-input.bootstrap.less',
		'ng-tags-input/ng-tags-input.less',
		'sb-admin-2/sb-admin-2.less',
		'droplet/droplet.less']);
});

elixir(function(mix) {
	mix.scripts('cbc.js', 'resources/assets/js','public/js/cbc.js');
});


elixir.extend('combineScripts', function(scripts) {
	gulp.task('combineScripts', function() {
		for (var i in scripts) {
			var script = scripts[i];

			var input = path.join(script.folder, '**/*.js');
			var output = path.basename(script.folder) + '.js';
			var dest = script.output || '.';

			gulp.src(input).pipe(concat(output)).pipe(gulp.dest(dest));
		}
	});

	return this.queueTask('combineScripts');
});

elixir(function(mix) {
	mix.combineScripts([
		{folder: 'resources/assets/js/libs', output: 'public/js'},
		{folder: 'resources/assets/js/FileManagement', output: 'public/js'},
		{folder: 'resources/assets/js/SocialNetwork', output: 'public/js'},
		{folder: 'resources/assets/js/controllers/user', output: 'public/js'},
		{folder: 'resources/assets/js/controllers/backoffice', output: 'public/js'},
		{folder: 'resources/assets/js/controllers/experience', output: 'public/js'},
		{folder: 'resources/assets/js/controllers/booking', output: 'public/js'},
		{folder: 'resources/assets/js/controllers/welcome', output: 'public/js'},
		{folder: 'resources/assets/js/controllers/auth', output: 'public/js'},
		{folder: 'resources/assets/js/values/adminValue', output: 'public/js'},
		{folder: 'resources/assets/js/values/userValue', output: 'public/js'}
	]);
});

/*
 elixir(function(mix) {
 mix.scripts(['browser.js', 'browser-polyfill.js', 'async.js', 'tadate.js', 'taquery.js', 'tadom.js', 'tar.js', 'tab.js'],
 'public/js/tajmall.js', 'resources/assets/js/TajMall');
 });*/

/*
 elixir(function(mix) {
 mix.babel('*.js', {
 srcDir: 'resources/assets/js/cbc',
 output: 'public/js'
 });
 });*/