/*
 * Created by {your name}.
 * User: {slack, skype}
 * For: {package}
 * License: Wooter LLC.
 * Date: 2015.12.31
 * Description:
 *
 */
__Wooter.factory('Util', ['$rootScope', '$state',function($rootScope, $state){
    var utilities = {};

    utilities.reload = function(link, time) {
        if(link && typeof link == 'string'){
            if(time && typeof time == 'number'){
                setTimeout(function(){
                    window.location.href = link;
                }, time);
            } else {
                window.location.href = link;
            }
        } else {
            window.location.reload();
        }
    };

    utilities.url = function(url){
        url = (url)?url:'';
        if (url.substr(0, 4) == "http" || url.substr(0, 4) == "www." || url.substr(0, 2) == "//") {
            $link = url;
        } else {
            var host = window.location.href;
            var $link = host.split('#');

            if(url.charAt(0) == '/'){
                url = url.substr(1);
            }

            $link = $link[0]+'#/'+url;
        }

        return $link;
    };

    utilities.route = function (url){
        var current = (url)?$state.href(url):$state.href($state.current.name);

        if (current == null) {
            current = $state.href('404');
        }

        if (current == '#') {
            current = $state.href('home');
        }

        var $route = current.replace('#', '');
        $route = utilities.url($route);

        return $route;
    };

    utilities.asset = function(asset){
        return $asset(asset);
    };

    utilities.randomChars = function(n){
        var text = "";
        var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
        for( var i=0; i < n; i++ )
            text += possible.charAt(Math.floor(Math.random() * possible.length));
        return text;
    };

    return utilities;
}]);