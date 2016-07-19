/*
 * Created by {your name}.
 * User: {slack, skype}
 * For: {package}
 * License: Wooter LLC.
 * Date: 2016.01.06
 * Description:
 *
 */
__Wooter.factory('Page', ['$window', '$http', '$q', '$rootScope', 'Util', function($window, $http, $q, $rootScope, Util){
    var factory = {};

    document.faviconBadge = 0;
    document.favicon = new Favico({
        animation: 'slide'
    });

    factory.title = function (title){
        document.querySelector('title').innerText = title;
        document.title = title;
    };

    factory.favicon = {
        setIcon: function(icon, nr){
            if(icon && typeof icon == "string"){
                var image = document.createElement('img');
                image.src = $rootScope.asset(icon);
                document.favicon.image(image);
            }
            if(nr && typeof nr == "number"){
                document.favicon.badge(nr);
                document.faviconBadge = nr;
            } else {
                if(icon && typeof icon == "number"){
                    document.favicon.badge(icon);
                }
                document.faviconBadge = icon;
            }
        },
        badge: {
            decrease: function(){
                factory.favicon.badge.decreaseWith(1);
            },
            increase: function(){
                factory.favicon.badge.increaseWith(1);
            },
            decreaseWith: function(n){
                n = (n)?n:1;
                document.favicon.badge(document.faviconBadge-n);
                document.faviconBadge = document.faviconBadge-n;
            },
            increaseWith: function(n){
                n = (n)?n:1;
                document.favicon.badge(document.faviconBadge+n);
                document.faviconBadge = document.faviconBadge+n;
            },
            setBadge: function(n){
                document.favicon.badge(n);
                document.faviconBadge = n;
            },
            clear: function(){
                document.favicon.badge(0);
            }
        }
    };

    factory.cleanAssets = function (type){
        type = (type)?type:'all';
        var remover = function (elements){
            angular.forEach(elements, function(value){
                value.remove();
            });
        };

        var object = {
            scripts: function(){
                var scripts = document.querySelectorAll('.page-script');
                remover(scripts);
            }, 
            styles: function(){
                var styles = document.querySelectorAll('.page-stylesheet');
                remover(styles);
            }
        };

        switch(type){
            case 'scripts':
                object.scripts();
                break;

            case 'stylesheets':
                object.styles();
                break;

            default:
                object.scripts();
                object.styles();
                break;
        }

    };

    // adding css to page
    factory.stylesheets = function(styles){
        // creating dom element link
        var createStyleElement = function (file) {
            var link = document.createElement('link');
            link.rel = "stylesheet";
            link.type = "text/css";
            link.href = Util.asset(file);

            link.classList.add('page-stylesheet');

            return link;
        };

        // add link element
        var addStyle = function(dom){
            var domLink = createStyleElement(dom);

            var head = document.querySelector('head');
            head.appendChild(domLink);

        };

        if (typeof styles === "string") {
            addStyle(styles);
        }

        if (typeof styles === "object") {
            angular.forEach(styles, function(style){
                if (typeof style === "string") {
                    addStyle(style);
                }
            })
        }
    };

    factory.css = factory.stylesheets;
    factory.style = factory.stylesheets;

    // adding js to page
    factory.scripts = function(scripts){
        // creating dom element link
        var createScriptElement = function (file) {
            var script = document.createElement('script');
            script.type = "text/javascript";
            script.src = Util.asset(file);
            script.setAttribute('defer', '');
            script.setAttribute('async', 'false');

            script.classList.add('page-script');

            return script;
        };

        // add link element
        var addScript = function(dom){
            var domLink = createScriptElement(dom);

            var head = document.querySelector('head');
            head.appendChild(domLink);

        };

        if (typeof scripts === "string") {
            addScript(scripts);
        }

        if (typeof scripts === "object") {
            angular.forEach(scripts, function(script){
                if (typeof script === "string") {
                    addScript(script);
                }
            })
        }
    };

    factory.js = factory.scripts;

    factory.reset = function(){

        factory.title('Wooter');
        factory.cleanAssets();
        factory.favicon.badge.clear();
        $rootScope.clearNotify();

    };

    return factory;
}]);