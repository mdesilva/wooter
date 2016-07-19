__Wooter.constant("language", getMeta('lang'));
__Wooter.constant("LANG", getMeta('lang'));

__Wooter.config(['$httpProvider', '$mdThemingProvider',function($httpProvider, $mdThemingProvider) {
    $httpProvider.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

    $mdThemingProvider.theme('auth-form')
        .primaryPalette('light-blue')
        .accentPalette('grey', {"default":'100'});

    $mdThemingProvider.theme('wooter-black')
        .primaryPalette('grey', {default: "900"})
        .accentPalette('red', {"default":'400'});

    $mdThemingProvider.theme('wooter-red')
        .primaryPalette('red', {"default":'400'});

    $mdThemingProvider.alwaysWatchTheme(true);

}]);

__Wooter.config(function($stateProvider, $urlRouterProvider, $authProvider, $httpProvider, $provide) {

    function redirectWhenLoggedOut($q, $injector) {
        return {
            responseError: function (rejection) {

                /**
                 * Need to use $injector.get to bring in $state or else we get a circular dependency error
                 */
                var $state      = $injector.get('$state');
                var Authentify  = $injector.get('Authentify');

                /**
                 * Instead of checking for a status code of 400 which might be used for other reasons in Laravel,
                 * we check for the specific rejection reasons to tell us if we need to redirect to the login state
                 *
                 * @type {string[]}
                 */
                var rejectionReasons = ['token_not_provided', 'token_expired', 'token_absent', 'token_invalid'];

                /**
                 * Loop through each rejection reason and redirect to the login state if one is encountered
                 */
                angular.forEach(rejectionReasons, function (value, key) {
                    if(!isNull(rejection.data)){
                        if (rejection.data.error === value) {
                            Authentify.Clean.auth();
                            $state.go('login');
                        }
                    }
                });

                return $q.reject(rejection);
            }
        }
    }

    /**
     * Setup for the $httpInterceptor
     */
    $provide.factory('redirectWhenLoggedOut', redirectWhenLoggedOut);

    /**
     * Push the new factory onto the $http interceptor array
     */
    $httpProvider.interceptors.push('redirectWhenLoggedOut');
    $authProvider.loginUrl = '/api/authenticate';
});

__Wooter.run(['$rootScope', '$http', 'Authentify', 'TRANS', 'Util', 'CONFIGS', '$mdToast', '$state', 'Notify', 'STORE', '$timeout', 'ZIP', '$auth', '$cookies', function($rootScope, $http, Authentify, TRANS, Util, CONFIGS, $mdToast, $state, Notify, STORE, $timeout, ZIP, $auth, $cookies){

    /*
     * Define Store instances to manipulate Browser Storage (sessionStorage && localStorage)
     */
    var $store = STORE();
    window.$$store = STORE();
    window.notify = [];
    window.$$notify = Notify();

    /*
     * Load ZIP and Coordinates
     */
    ZIP.setZip(function(zip, coords){
        $store.local.create('zip', zip);
        $store.local.create('coords', coords);
    });

    /*
     * Get Configs of website and store to window object
     */
    CONFIGS.set();

    /*
     * Define global value into $scope to check if the user is authenticated
     */
    $rootScope.authenticated = Authentify.GET.authCheck();

    /*
     * Define global function into $scope for reload page
     */
    $rootScope.reload = function(link, time){
        Util.reload(link, time);
    };

    /*
     * Define global function into $scope for reload page
     */
    $rootScope.intval = function(a){
        return parseInt(a);
    };
    $rootScope.parseInt = $rootScope.intval;

    /*
     * Define global function into $scope for logout user
     */
    $rootScope.logout = function(after){
        Authentify.logout(after);
    };

    /*
     * Define global function into $scope for translate
     */
    $rootScope.trans = function(trans, data, no){
        return TRANS.translate(trans, data, no);
    };

    /*
     * Define global function into $scope for range
     */
    $rootScope.range = function(a,b){
        return range(a,b);
    };

    /*
     * Define global value into $scope for actual languages
     */
    $rootScope.language = TRANS.language;

    /*
     * Define global object into $scope for available languages
     */
    $rootScope.languages = TRANS.languages;

    /*
     * Define global function into $scope with user informations
     */
    $rootScope.User = function(data){
        var user = Authentify.GET.user();
        return (user)?((data)?user[data]:user):{};
    };

    /*
     * Define global function into $scope for get url of website
     */
    $rootScope.url = function(url){
        Util.url(url)
    };

    /*
     * Define global function into $scope for get url of route
     */
    $rootScope.route = function(url){
        return Util.route(url);
    };

    /*
     * Define global function into $scope for get utl to website asset
     */
    $rootScope.asset = function(asset){
        return Util.asset(asset);
    };

    /*
     * Define global function into $scope for get a random chars
     */
    $rootScope.random = function (n){
        Util.randomChars(n);
    };

    /*
     * Define global function into $scope for get system view (laravel blade)
     */
    $rootScope.bladeView = function (n){
        return bladeView(n);
    };

    /*
     * Define global function into $scope for clear notifications
     */
    $rootScope.clearNotify = function (){
        Notify().clear();
    };

    /*
     * Define global function into $scope for get a template from front system (angular views), by type of device
     */
    $rootScope.logicTemplate = function (a, b){
        return logicTemplate (a, b);
    };

    /*
     * Define global function into $scope for get length if a object or string
     */
    $rootScope.count = function (a){
        return count (a);
    };

    /*
     * Define global function into $scope create a simple toast
     */
    $rootScope.simpleToast = function(message, position) {
        position = (position)?position:'top right';

        var toast = $mdToast.simple()
            .textContent(message)
            .action('OK')
            .highlightAction(false)
            .position(position);

        $mdToast.show(toast);
    };
    /*
     * Define global function into $scope to get svg files
     */
    $rootScope.svg = function(a,b,c){
        return svg(a, b, c);
    };

    /**
     * Define Loader actions
     */
    $rootScope.loading = loading;

    $rootScope.loaded = loaded;
    /*
     * Except routes by controller (word, group of chars or full name)
     */
    var $excepts = [
        //'results' used to Except Controller "Results/ResultController" or all controllers who contain results
        'Results/ResultController',
        'Error/404'
    ];

    /*
     * Function executed before view content loaded and after loaded
     */
    $rootScope.$on('$viewContentLoading', function(event, viewConfig){});

    $rootScope.$on('$viewContentLoaded', function (event) {
        $('body').removeClass('hide');
        var $except = false;

        angular.forEach($excepts, function(val){
            if(!isNull($state.current.views)){
                if(angular.isDefined($state.current.views.main) && angular.isDefined($state.current.views.main.controller)){
                    if($state.current.views && $state.current.views.main.controller.toString().toLowerCase().indexOf(val.toString().toLowerCase()) > -1){
                        $except = true;
                        return false;
                    } else {
                        $except = false;
                    }
                } else {
                    $except = false;
                }
            } else {
                $except = false;
            }
        });

        $('a').each(function(index, el) {
            if ($(this).attr('href') == '#'){
                $(this).attr('href', 'javascript:void(0);');
            }
        });

        if($except){
            $('.page-anim').addClass('show');
        }

        setTimeout(function () {
            loaded();
            $('body').removeClass('no-scroll');
            $('.page-anim').addClass('show');
        }, 500);
    });

    $rootScope.$on('$stateChangeStart', function(event, toState) {
        var user = Authentify.GET.user();
        if(Authentify.GET.authCheck()){
            if(count(user) > 0) {
                $rootScope.authenticated = true;
                $rootScope.user = user;
            }
        }

        /**
         * Clean previous include events
         */
        $$store.session.create('include_events', []);
    });

    /*
     * If application are in production mode on errors will show 409 error
     */
    if (!getMeta('dev')) {
        $rootScope.$on('$stateChangeError', function(event) {
            $state.go('409');
        });
    }

    /**
     * Add file to events item from session storage
     */
    $rootScope.$on('$includeContentLoaded', function (e, include) {

        $('a').each(function(index, el) {
            if ($(this).attr('href') == '#'){
                $(this).attr('href', 'javascript:void(0);');
            }
        });

        var event = filenameEvent(include);

        if($$store.session.check('include_events')){
            var events = angular.fromJson($$store.session.get('include_events'));
            events.push(event);
            $$store.session.create('include_events', angular.toJson(events));
        } else {
            $$store.session.create('include_events', angular.toJson([event]));
        }

        $(document).trigger(event);
    });

}]);
