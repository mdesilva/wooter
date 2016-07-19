/**
 * Created by Dumitrana Alinus.
 * User: alin.designstudio
 * For: Middlewares
 * License: Wooter LLC.
 * Date: 05.03.2016
 * Description: $middleware is function who return a middleware function used for routes or for other things.
 */
function $middleware(m){

    var $middlewares = {
        /**
         * Route Middleware, access route just if user are logged
         * Use method example
         *  .state('routeName', {
         *      url: '/url/to/route',
         *      views: {
         *          main: {
         *              resolve: {
         *                  loginRequired: $middleware('loginRequired')
         *              }
         *          }
         *      }
         *  });
         *
         * @scope This is used just in routes
         * @returns {*}
         */
        loginRequired: function ($rootScope, $q, $state, Authentify) {
            var deferred = $q.defer();
            if (Authentify.GET.authCheck()) {
                deferred.resolve();
            } else {
                $state.go('login');
                $rootScope.$emit('$viewContentLoaded');
            }
            return deferred.promise;
        },

        /**
         * Route Middleware, access route just if user not logged
         * Use method example
         *  .state('routeName', {
         *      url: '/url/to/route',
         *      views: {
         *          main: {
         *              resolve: {
         *                  skipIfLoggedIn: $middleware('skipIfLoggedIn')
         *              }
         *          }
         *      }
         *  });
         *
         * @scope This is used just in routes
         * @returns {*}
         */
        skipIfLoggedIn: function ($rootScope, $q, $state, Authentify) {
            var deferred = $q.defer();
            if (Authentify.GET.authCheck()) {
                $state.go('leaguesList');
                $rootScope.$emit('$viewContentLoaded');
            } else {
                deferred.resolve();
            }
            return deferred.promise;
        },

        /**
         * IsOrganization Middleware
         *
         * @param $rootScope
         * @param $q
         * @param $state
         * @param Authentify
         * @returns {*}
         * @param $stateParams
         * @param API
         */
        isOrganization: function ($rootScope, $q, $state, Authentify, $stateParams, API) {
            var $leaguesAPI = API.exec('leagues');
            var leagueId = $stateParams.league_id;
            var deferred = $q.defer();

            if (Authentify.GET.authCheck()) {
                if($rootScope.User('organization')){

                    if (typeof leagueId != 'undefined') {
                        $leaguesAPI.isOwner({leagueId: leagueId}, function(response) {
                            if (response.data == 'Success') {
                                deferred.resolve();
                            } else {
                                $state.go('notAllowed');
                                $rootScope.$emit('$viewContentLoaded');
                            }
                        }, function() {
                            $state.go('notAllowed');
                            $rootScope.$emit('$viewContentLoaded');
                        });
                    } else {
                        deferred.resolve();
                    }
                } else {
                    $state.go('notAllowed');
                    $rootScope.$emit('$viewContentLoaded');
                }
            } else {
                $state.go('notAllowed');
                $rootScope.$emit('$viewContentLoaded');
            }

            return deferred.promise;
        }
    };

    return (m in $middlewares)?$middlewares[m]:false;
}
