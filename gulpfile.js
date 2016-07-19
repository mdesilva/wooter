/**
 *
 * In construction
 * Developer: Alinus,
 * Scope: Minify and prepare app front end
 *
 */
var elixir = require('laravel-elixir');
var gulp = require('gulp');
var minify = require('gulp-minify');

require('laravel-elixir-remove');
require('laravel-elixir-ng-annotate');

var assets = {
	css: require('./public/config/assets/css.json'),
	js: require('./public/config/assets/js.json'),
	app: require('./public/config/assets/app.json'),
	angular: require('./public/config/assets/angular.json')
};

var config = {
	browserSync: require('./public/config/browserSync.json')
};

elixir.config.sourcemaps = false;
elixir.config.production = false;

var publicPath = function (file) {
	var file = '../../../public'+'/'+file;
	return file.split('//').join('/');
};

var pathCleaner = function (dir, file, type, ext, idc) {
	var $file = file;
	$file = ($file.slice(0, 1) == '/')?$file.slice(1):$file;
	$file = $file.replace('.'+ext, '');
	$file = $file.split('.').join('/');
	var ren = dir+'/'+$file+((idc)?'/index.':'.')+ext;
	ren = ren.split('//').join('/');
	return ren;
};

var getAssets = function(folder, type, ext, idc){
	var items = assets[type];
	var dir = publicPath(folder);
	var idc = (idc)?true:false;

	for (item in items) {
		var file = items[item];
		var ret = pathCleaner(dir, file, type, ext, idc);
		items[item] = ret;
	}

	return items;
};

var getAngularFiles = function(files){
	for(var k in files){
		var $module = '/js/vendors/angular/angular'+((files[k] == 'angular')?'':'-'+files[k])+'.js';
		files[k] = publicPath($module);
	}

	return files;
};

var Task = elixir.Task;


elixir.extend('minifyApp', function(){
	new Task('minifyApp', function(){
		return gulp.src('public/js/production/temp/app.js')
	    .pipe(minify({
	    	mangle: false,
	    	compress: true,
	    	preserveComments: false
	    }))
	    .pipe(gulp.dest('public/js/production/temp'));
	});
});

elixir(function(mix) {
	mix.remove(['public/js/production/app.js']);

	mix.sass(publicPath('scss/style.scss'), 'public/css/style.css');

	var styles = getAssets('css/', 'css', 'css', true);
	var scripts = getAssets('js/', 'js', 'js', true); 
	var appScripts = getAssets('js/', 'app', 'js', false);
	var angularFiles = getAngularFiles(assets.angular);

	styles.push(publicPath('css/style.css'));

	mix.styles(styles, 'public/css/production/style.css');

	for (var k in scripts) { angularFiles.push(scripts[k]) };
	for (var k in appScripts) { angularFiles.push(appScripts[k]) };

	mix.scripts(angularFiles, 'public/js/production/temp/app.js');

	mix.minifyApp();

	mix.copy('public/js/production/temp/app-min.js', 'public/js/production/app.js')

	mix.remove([
		'public/js/production/temp/'
	]);

    mix.browserSync(config.browserSync);
});
