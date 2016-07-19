/*
 * Created by Dumitrana Alinus.
 * User: alin.designstudio
 * For: Configs
 * License: Wooter LLC.
 * Date: 2016.01.28
 * Description:
 *
 */
__Wooter.factory('CONFIGS', ['$window', '$http', function($window, $http){
    var factory = {};

    factory.set = function (){
        $http({
            method  : 'POST',
            url     : '/api/config/website',
            data    : {
            }
        }).then(function(response) {
            var $cfg = angular.fromJson(response.data);
            if (window.front){
                window.front.config = $cfg;
            } else {
                window.front = {
                    config: $cfg
                }
            }
        }, function(response) { });
    };

    factory.getAll = function (){
        return window.front.config;
    };

    factory.get = function (a){
        return window.front.config[a];
    };


    return factory;
}]);