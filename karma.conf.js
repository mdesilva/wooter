// Karma configuration
// Generated on Mon Feb 29 2016 15:12:29 GMT+0300 (MSK)

module.exports = function(config) {

    function getFiles() {
        var cleanAppFile = function (file){
            file = file.split('.').join('/');
            file = './public/js/'+file+'/index.js';
            file = file.split('//').join('/');

            return file.toString();
        };

        var cleanNgFile = function (file){
            file = (file == 'angular')?'':'-'+file;
            return './public/js/vendors/angular/angular'+file+'.js';
        };

        var cleanLoadAppFile = function (file){
            return './public/js/app/'+file+'/**/*.js';
        };

        /*
         * Get Files from JSON Configs
         */
        var angular_files = require('./public/config/assets/angular.json');
        var app_files = require('./public/config/assets/js.json');
        var init_files = require('./public/config/assets/init.json');

        var loadApp = [
            'functions',
            'factories',
            'app',
            'directives',
            'controllers',
            //'routes',
            'tests'
        ];

        /*
         * Define Files Array
         */
         var $files = [
            //jquery
            './public/js/vendors/jquery/index.js'
         ];

        /*
         * Add Angular Files to $files array
         * @use angular_files
         */
         for(var b in angular_files){ $files.push(cleanNgFile(angular_files[b])) }
        $files.push('./public/js/vendors/angular/angular-mocks.js');
        /*
         * Add App init Files to $files array
         * @use app_files
         */
         for(var a in app_files){ $files.push(cleanAppFile(app_files[a])) }

        /*
         * Add App init Files to $files array
         * @use init_files
         */ 
         for(var a in app_files){ $files.push(cleanAppFile(init_files[a])) }
       
        /*
         * Add App Files to $files array
         * @use loadApp
         */
         for(var b in loadApp){ $files.push(cleanLoadAppFile(loadApp[b])) }

        return $files;
    }

    config.set({

        // base path that will be used to resolve all patterns (eg. files, exclude)
        basePath: './',

        // frameworks to use
        // available frameworks: https://npmjs.org/browse/keyword/karma-adapter
        frameworks: ['jasmine'],

        // list of files / patterns to load in the browser
        files: getFiles(),

        // list of files to exclude
        exclude: [],

        // preprocess matching files before serving them to the browser
        // available preprocessors: https://npmjs.org/browse/keyword/karma-preprocessor
        preprocessors: {},

        // test results reporter to use
        // possible values: 'dots', 'progress'
        // available reporters: https://npmjs.org/browse/keyword/karma-reporter
        reporters: ['progress'],

        // web server port
        port: 9876,

        // enable / disable colors in the output (reporters and logs)
        colors: true,

        // level of logging
        // possible values: config.LOG_DISABLE || config.LOG_ERROR || config.LOG_WARN || config.LOG_INFO || config.LOG_DEBUG
        logLevel: config.LOG_INFO,

        // enable / disable watching file and executing tests whenever any file changes
        autoWatch: true,

        // start these browsers
        // available browser launchers: https://npmjs.org/browse/keyword/karma-launcher
        browsers: ['Chrome'],

        // Continuous Integration mode
        // if true, Karma captures browsers, runs the tests and exits
        singleRun: false,

        // Concurrency level
        // how many browser should be started simultaneous
        concurrency: Infinity
    })
};