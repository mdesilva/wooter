/**
 * Created by Dumitrana Alinus.
 * User: alin.designstudio (skype)
 * For: Auth System
 * License: Wooter LLC.
 * Date: 2015.12.31
 * Description: Factory to control Auth System
 *
 */
__Wooter.factory('Authentify', ['$window', '$http', '$q', '$rootScope', '$state', 'STORE', 'Notify', '$auth', '$cookies', function ($window, $http, $q, $rootScope, $state, STORE, Notify, $auth, $cookies){

    /**
     * Check if JWT Token not is expired
     *
     * @returns {*}
     */
    function checkIfIsValidToken() {
        if(atob || window.atob){
            var $ret;
            var data = $auth.getPayload();

            var now = new Date().getUnix();
            var expiration = data.exp;

            if(now > expiration){
                $auth.removeToken();
                $ret = false;
            } else {
                $ret = true;
            }

            return $ret;
        }
    }
    /**
     * Short logout Helper
     */
    function logout() {
        $auth.logout().then(function() { factory.Clean.auth() });
    }

    /**
     * Define Instance of factory
     */
    var factory = {};

    /**
     * Default type of store auth session
     */
    factory.default = {
        store: 'local'
    };

    /**
     * Store methods
     *
     * @returns {null/object}
     * @param method
     */
    factory.STORAGE = function(method){
        var $ret;
        method = (method)?method:'primary';
        switch (method){
            case 'primary':
                $ret = (factory.default.store != 'session')?STORE().local:STORE().session;
                break;
            case 'secondary':
                $ret = (factory.default.store == 'session')?STORE().local:STORE().session;
                break;
            default:
                $ret = null;
                break
        }

        return $ret;
    };

    /**
     * Auth Middleware
     */
    factory.middleware = {
        /**
         * If user are authentificated will redirect to dashboard page else will return true
         * This Middleware is used at pages who don't need display if are logged
         *
         * @returns {boolean}
         */
        notLogged: function(){
            var check = factory.GET.authCheck();
            if (check == true) {
                $state.go('dashboard');
            } else {
                return true;
            }
        },
        /**
         * If user are authentificated will redirect to index page else will return true
         * This Middleware is used at pages who need display if are logged
         *
         * @returns {boolean}
         */
        isLogged: function(){
            var check = factory.GET.authCheck();
            if (check != true) {
                $state.go('login');
            } else {
                return true;
            }
        }
    };

    /**
     * Get methods object
     */
    factory.GET = {
        /**
         * Check if Auth session are stored (first is checked session, if session no exist check local)
         * If Satellizer token don't exist will logout and clean auth and user data
         *
         * @returns {*|boolean|null}
         */
        authCheck: function(){
            var ret;
            if(factory.GET.tokenCheck()) {
                if(checkIfIsValidToken() && $auth.isAuthenticated()){

                    if(factory.GET.session()){
                        var session = factory.GET.session();
                        var now = new Date().getUnix();

                        if(now > session.exp){
                            if($cookies.get('session_open')) {
                                factory.SET.session(session.user);
                            } else {
                                factory.Destroy.session();
                            }
                        } else {
                            if($cookies.get('session_open')){
                                factory.STORAGE().store('auth', session.auth);
                                factory.SET.user(session.user);
                            } else {
                                logout('cck');
                            }
                        }
                    }

                    if($cookies.get('session_open')){
                        if(factory.STORAGE('primary').check('auth')){
                            $ret = factory.STORAGE('primary').get('auth');
                        } else {
                            $ret = false;
                        }
                    } else {
                        logout();
                        $ret = false;
                    }

                } else {
                    logout();
                    $ret = false;
                }
            } else {
                logout();
                $ret = false;
            }
            return $ret;
        },

        /**
         * Get user object from Storages (first is checked session, if session no exist check local)
         *
         * @returns {*|boolean|null}
         */
        user: function(){
            var ret;
            if(factory.STORAGE('primary').check('user')){
                $ret = angular.fromJson(atob(factory.STORAGE('primary').get('user')));
            } else {
                $ret = null;
            }
            return $ret;
        },
        /**
         * Check if Satellizer token exist
         *
         * @returns {boolean}
         */
        tokenCheck: function(){
            return STORE().local.check('satellizer_token');
        },
        token: function(){
            return $auth.getToken();
        },
        session: function(){
            if(atob || window.atob){
                if(factory.STORAGE('primary').check('auth_session')){
                    return angular.fromJson(atob(factory.STORAGE('primary').get('auth_session')))
                } else {
                    return null;
                }

            } else {
                return null;
            }
        }
    };

    /**
     * Set methods object
     */
    factory.SET = {
        /**
         * Store new user token (if remeber true will store at local else will store at session)
         *
         * @param {object|string} $token
         */
        token: function($token){
            $auth.setToken($token);
        },
        /**
         * Store user object (if remeber true will store at local else will store at session)
         *
         * @param {object|string} $user
         */
        user: function($user){
            factory.STORAGE('primary').create('user', btoa(angular.toJson($user)));
        },
        /**
         * Store session
         *
         * @param {object} user
         */
        session: function(user){
            var now = new Date().getUnix();

            var data = {
                user: user,
                auth: true,
                exp: now+60,
                int: now
            };

            STORE().local.store('auth_session', btoa(angular.toJson(data)));
        }
    };

    /**
     * Destroy methods object
     */
    factory.Destroy = {
        /**
         * Delete auth session
         */
        auth: function(){
            if(factory.STORAGE('primary').check('auth')){
                factory.STORAGE('primary').destroy('auth');
            } else {
                factory.STORAGE('secondary').destroy('auth');
            }
        },
        /**
         * Delete user data
         */
        user: function(){
            if(factory.STORAGE('primary').check('user')){
                factory.STORAGE('primary').destroy('user');
            } else {
                factory.STORAGE('secondary').destroy('user');
            }
        },
        /**
         * Delete Session identifier
         */
        session: function(){
            $cookies.remove('session_open');
            if(factory.STORAGE('primary').check('auth_session')){
                factory.STORAGE('primary').destroy('auth_session')
            }
        }
    };

    /**
     * Clean methods object
     */
    factory.Clean = {
        /**
         * Clean auth data
         */
        auth: function(){
            factory.Destroy.auth();
            factory.Destroy.user();
            factory.Destroy.session();
            $rootScope.authenticated = false;
            $rootScope.user = null;
        }
    };

    /**
     * Clean methods object
     */
    factory.Request = {
        /**
         * Jobs after login if auth exist
         * @param {object|array} response
         */
        authCheck: function(response){
            if (response){
                factory.STORAGE('primary').create('auth', true);
                factory.SET.user(response.data.user);

                $cookies.put('session_open', true);

                window.onbeforeunload = function() {
                    factory.SET.session(response.data.user);
                    factory.Destroy.auth();
                    factory.Destroy.user();
                };

                $rootScope.authenticated = true;
                $rootScope.user = response.data.user;

                $state.go('leaguesList');
            }
        }
    };

    /**
     * Login function
     * @param {object} $data
     * @param btn
     */
    factory.login = function($data, btn){
        //Show Loader
        loading();
        angular.element(btn).attr('disabled', 'disabled');
        
        var Events = {
            success: function(response){

                loaded();
                angular.element(btn).removeAttr('disabled');

                Notify({
                    message: 'Successful Authentication! We will redirect to dashboard in some moments!',
                    timeout: 3000,
                    type: 'success',
                    inverse: true,
                    icon: true
                });

                return $http.get('api/check-auth');
            },
            error: function(response){
                var $message;

                loaded();
                angular.element(btn).removeAttr('disabled');


                switch (response.data.error) {
                    case 'invalid_credentials':
                        $message = 'Incorrect credentials.';
                        break;

                    case 'The user is Deactivated':
                        $message = 'The user is Deactivated';
                        break;

                    case 'could_not_create_token':
                        $message = 'Token could not be created.';
                        break;

                    default:
                        $message = 'Something went wrong!';
                        break;
                }

                Notify({
                    message: $message,
                    timeout: 5000,
                    type: 'warning',
                    protect: false,
                    inverse: true,
                    icon: true
                });
            }
        };

        $auth
            .login($data)
            .then(Events.success, Events.error)
            .then(factory.Request.authCheck);
    };

    /**
     * Register function
     *
     * @param {object} $data
     * @param {function} $success
     * @param {function} $error
     */
    factory.register = function($data, $success, $error){
        $http({
            method  : 'POST',
            url     : '/register',
            data    : $data
        })
        .then(function successCallback(response) {
            $success(response);
        }, function errorCallback(response) {
            $error(response);
        });
    };

    /**
     * Auth Check
     * @type {factory.GET.authCheck}
     */
    factory.check = factory.GET.authCheck;

    /**
     * Logout function
     */
    factory.logout = function(){
        if (factory.GET.authCheck()) {
            $auth
            .logout()
            .then(function() {
                factory.Clean.auth();
                $state.go('index');
            });
        } else {
            $state.go('login');
        }
    };

    factory.token = factory.GET.token;

    return factory;
}]);
