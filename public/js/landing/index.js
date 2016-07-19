$( document ).ready(function() {
    console.log("ready");
      
    $('.open_link').click(function() {
        var link = $("a",this).attr('href');
        window.open(link, '_self');
    });

    $('.dropping').click(function() {
        return true;
    });

    $('.how').click(function(){
        $('#how_works').addClass( "dropdown" );
        $('#how_works').removeClass( "dropup" );
    });

    $('.x-close').click(function(){
        $('#how_works').addClass( "dropup" );
        $('#how_works').removeClass( "dropdown" );
    });

    $('.how').click(function(){
        $('#how_works').addClass( "dropdown" );
        $('.wooter_mobile_header').toggleClass( "dropup" );
    });

    $('.tab').click(function(){
        $(this).closest( ".tab" ).find('.plus_minus').toggleClass( "hide" );
        $(this).closest( ".tab" ).find('.answer').toggleClass( "hide" );

    });    

    $( ".jersey" ).hover(
      function() {
        $(this).find( ".image" ).addClass( "gradient" );
        $(this).addClass( "md-whiteframe-4dp" );
      }, function() {
        $(this).find( ".image" ).removeClass( "gradient" );
        $(this).removeClass( "md-whiteframe-4dp" );
      }
    );

    $('.name_input').focus(function(){
        $(this).closest( ".selection" ).find('.name_label').addClass( "label_change" );
    });

    $('.name_input').blur(function(){
        if(!$('.name_input').val()){
            $(this).closest( ".selection" ).find('.name_label').removeClass( "label_change" );
        } 
    });
});

setInterval(function(){ 
        $(".space_one").height($(".popup_one").height());
        $(".space_two").height($(".popup_two").height());
        $(".space_three").height($(".popup_three").height());
}, 10);

landing.factory('Util', ['$rootScope', '$state',function($rootScope, $state){
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

landing.factory('Page', ['$window', '$http', '$q', '$rootScope', 'Util', function($window, $http, $q, $rootScope, Util){
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

landing.factory('Notify', ['$window', 'Util', '$compile', '$sce', "$rootScope", 'Page', '$timeout', function($window, Util, $compile, $sce, $rootScope, Page, $timeout){
    "use strict";
    var notifyfab = function(a, b, c){
        if(a && typeof a == "string" || typeof a == "number"){
            a = {message: a};
        }
        if (b){
            switch (typeof b){
                case "string":
                    if(b == parseInt(b)){
                        a.timeout = b;
                    } else {
                        a.type = b;
                    }
                    break;
                case "number":
                    a.timeout = b;
                    break;
                case "boolean":
                    a.timeout = (b)?true:false;
                    break;
                case "function":
                    a.onConfirm = b;
                    a.buttons = true;
                    break;
            }
        }
        if(c && typeof c == "function"){
            a.onCancel = c;
            a.buttons = true;
        }
        if(a){
            this.create(a);
        } else {
            if (a === false){
                return undefined;
            } else {
                return this.instance;
            }
        }
    };

    var factory = notifyfab.prototype;

    factory.defaults = function(){
        return {
            title: undefined,                   // Title of notification, can be undefined or string
            message: undefined,                 // Message of notification, can be undefined or string
            shadow: 4,                          // Size of shadow according with examples from https://material.angularjs.org/latest/demo/whiteframe
            inverse: true,                      // Boolean value (true or false), if is true reverse theme of notification
            type: "info",                       // String/number { error/(0), success/(1), info/(2), warning/(3) }, type and theme of notifycation
            fontIcon: "font-awesome",           // Type of font icon, momentanly is availible just font-awesome or material
            icon: false,                        // Icon of notification (according with fontIcon value, default font-awesome), false (will hide), true will show default icons

            timeout: 5000,                      // Time for auto closing, number. If want to keep notify put false;

            classes: [],                        // String or object ( "class1 class2" or ["class1", "class2"]), optional classes for notify parent
            buttons: false,                     // Show or Hide buttons, can be just true or false
            confirmButtonText: "Confirm",       // Text of confirm button
            cancelButtonText: "Cancel",         // Text of cancel button

            protect: true,                      // Filter text (title, message and button texts) to protect xss attacks

            onConfirm: function(){},            // Function for event click of confirm button
            onCancel: function(){},             // Function for event click of cancel button

            confirmButtonShow: true,            // Hide or show Confirm Button
            cancelButtonShow: true,             // Hide or show Cancel Button

            confirmButtonClasses: [],           // Classes for confirm button
            cancelButtonClasses: []             // Classes for cancel button
        };
    };

    factory.container = document.getElementById('notify-container');
    factory.containerInner = document.querySelector('#notify-container .notify-inner');
    factory.configs = {};
    factory.token = '';
    factory.TPL = '';

    factory.iconTemplates = {
        "font-awesome": 'i',
        'material': 'md-icon'
    };

    factory.extendOptions = function (a){
        factory.configs = angular.extend(factory.defaults(), a);
        factory.Clean.configs();
    };

    factory.hash = function(token){
        factory.token = token;
    };

    factory.notifyHash = function(){
        return 'notify-'+factory.token;
    };

    factory.Params = {

        filter: function(filterVal){
            var $return;

            if(typeof filterVal[0] == "object"){
                $return = {
                    type: "options",
                    val: filterVal
                };
            } else {
                if(typeof filterVal[0] == "string" || typeof filterVal[0] == "number"){
                    $return = {
                        type: "string",
                        val: filterVal
                    };
                }
            }

            return ($return)?$return:false;
        }

    };

    function removeNotifyFromList($hash) {
        var noifys = window.notify;
        window.notify = [];
        angular.forEach(noifys, function (val) {
            if(val != $hash){
                window.notify.push(val);
            }
        });
    }

    factory.Events = {
        setEvents: function(){
            factory.Events.add();
            factory.Events.closer();
            factory.Events.onConfirm();
            factory.Events.onCancel();
        },
        closer: function(){
            var closer = document.querySelector('.'+factory.notifyHash()+' .notify-close');
            if(closer){
                closer.onclick = function(){
                    factory.Events.hide(closer);
                    return false;
                }
            }
            var timeout = factory.configs.timeout;
            if(timeout && typeof timeout == "number" || timeout == parseInt(timeout)){
                var inner = document.querySelector('.'+factory.notifyHash()+' .inner');
                setTimeout(function(){
                    factory.Events.hide(inner);
                }, parseInt(timeout)+400);
            }
        },
        show: function(){
            var tpl = document.querySelector('.'+factory.notifyHash());
            setTimeout(function(){
                tpl.classList.add('open');
                setTimeout(function(){
                    tpl.style.height = tpl.offsetHeight+'px';

                    if(count(window.notify) > 4){
                        console.log('.' + window.notify[0]);
                        if (window.notify[0]) {
                            factory.Events.hide(document.querySelector('.'+window.notify[0]+' .inner'));
                            removeNotifyFromList(window.notify[0]);
                        }
                    }

                }, 350);
            }, 100);
        },
        hide: function(ele){
            ele.closest('li').classList.remove('open');
            ele.closest('li').classList.add('h0');
            $timeout(function(){
                factory.Events.remove(ele);
            }, 350);
        },
        add: function(){
            if (angular.isUndefined(window.notify)) {
                window.notify = [];
            }
            window.notify.push(factory.notifyHash());

            Page.favicon.badge.increase();
            factory.containerInner.insertBefore($compile(factory.TPL.outerHTML)($rootScope)[0], factory.containerInner.querySelectorAll('li')[0]);
            factory.Events.show();
        },
        remove: function(ele){
            var $hash;
            angular.forEach(ele.closest('li').classList,function (val) {
                if(val.indexOf('notify-') > -1){
                    $hash = val;
                    return false;
                }
            });

            removeNotifyFromList($hash);

            Page.favicon.badge.decrease();
            ele.closest('li').remove();
        },
        onConfirm: function(){
            var btn = document.querySelector('.'+factory.notifyHash()+' .confirmButton');
            if(btn){
                btn.onclick = function(e){
                    factory.configs.onConfirm(e, btn.closest('li'), btn);
                    factory.Events.hide(btn);
                    return false;
                }
            }
        },
        onCancel: function(){
            var btn = document.querySelector('.'+factory.notifyHash()+' .cancelButton');
            if(btn){
                btn.onclick = function(e){
                    factory.configs.onCancel(e, btn.closest('li'), btn);
                    factory.Events.hide(btn);
                    return false;
                }
            }
        }
    };

    factory.getType = function(){
        var $type;
        if(factory.configs.type === parseInt(factory.configs.type)){
            switch (factory.configs.type){
                case 0: $type = "error"; break;
                case 1: $type = "success"; break;
                case 3: $type = "warning"; break;
                case 2: $type = "info"; break;
            }
        } else {
            if(factory.configs.type != "danger"){
                $type = factory.configs.type;
            } else {
                $type = "error";
            }
        }
        return $type;
    };

    factory.getDefaultIcon = function(){
        var $icon;

        if(factory.configs.fontIcon == 'font-awesome'){
            switch (factory.configs.type){
                case "error": $icon = 'exclamation-circle'; break;
                case "success": $icon = "check"; break;
                case "info": $icon = "info"; break;
                case "warning": $icon = "exclamation-triangle"; break;
            }
        }

        if(factory.configs.fontIcon == 'material'){
            switch (factory.configs.type){
                case "error": $icon = 'error'; break;
                case "success": $icon = "check"; break;
                case "info": $icon = "info_outline"; break;
                case "warning": $icon = "warning"; break;
            }
        }

        return $icon;
    };

    factory.Clean = {
        configs: function(){
            factory.configs.type = factory.getType();
        },
        notify: function(){
            var k=0;
            var nt = document.querySelectorAll('.notify-inner li.notify');
            angular.forEach(nt, function (a, b) {
                var ntf = nt[nt.length-b-1];
                setTimeout(function(){
                    ntf.classList.remove('open');
                    setTimeout(function(){
                        ntf.remove();
                    },1000)
                }, k*350);
                k++;
            });
            Page.favicon.badge.setBadge(0);
            return factory.instance;
        }
    };

    factory.Options = {
        getIconType: function(){
            var $return = undefined;
            var settings = factory.configs;

            if(settings.icon === true){
                $return = {
                    type: settings.fontIcon,
                    icon: factory.getDefaultIcon()
                };
            }

            if(typeof settings.icon == "string" || typeof settings.icon == "number"){
                $return = {
                    type: settings.fontIcon,
                    icon: settings.icon
                };
            }

            return $return;
        }
    };

    factory.Template = {
        setTemplate:function(a){
            var $tpl = factory.Template.createTemplate();
            factory.TPL = $tpl;
            if(a){
                return $tpl;
            }
        },
        createTemplate:function(){
            var tpl = document.createElement('li');
            var classes = (factory.configs.classes &&  typeof factory.configs.classes == "string")?factory.configs.classes:factory.configs.classes.join(' ');
            tpl.classList.add('notify');
            tpl.classList.add(factory.notifyHash());
            tpl.setAttribute('class', tpl.getAttribute('class')+' '+classes);
            tpl.setAttribute('theme', factory.configs.type);
            tpl.setAttribute('layout', 'column');
            tpl.setAttribute('layout-align', 'center center');

            if(factory.configs.buttons){
                tpl.classList.add('have-buttons');
            }
            if(typeof  factory.configs.title != "undefined"){
                tpl.classList.add('have-title');
            }
            if(factory.configs.inverse){
                tpl.classList.add('inverse');
            }
            if(factory.configs.shadow == parseInt(factory.configs.shadow)){
                tpl.classList.add('md-whiteframe-'+parseInt(factory.configs.shadow)+'dp');
            }
            if (!factory.configs.icon){
                tpl.classList.add('no-icon');
            }

            tpl.appendChild(factory.Template.templates.body());

            return tpl;
        },
        templates: {
            icon: function(){
                var icon;
                var rawIcon = factory.Options.getIconType();
                if(rawIcon !== "undefined" && typeof rawIcon == "object"){

                    if(rawIcon.type in factory.iconTemplates){
                        var $icon = document.createElement(factory.iconTemplates[(rawIcon.type).toLowerCase()]);

                        switch ((rawIcon.type).toLowerCase()){
                            case "material":
                                $icon.innerText = rawIcon.icon;
                                break;

                            default:
                                $icon.classList.add('fa');
                                $icon.classList.add('fa-'+rawIcon.icon);
                                break;
                        }
                        var flex = document.createElement('div');
                        flex.setAttribute('flex', '20');
                        flex.setAttribute('layout-align', 'start center');
                        flex.classList.add('icon');
                        flex.innerHTML = $icon.outerHTML;

                        icon = flex;
                    } else {
                        throw new Error('Font icon not is in accepted templates! '+rawIcon.type+' instead (material or font-awesome)');
                    }

                } else {
                    icon = undefined;
                }

                return icon;
            },
            title: function(){
                var $return;
                if (typeof factory.configs.title !== "undefined" && typeof factory.configs.title !== "object"){
                    var title = document.createElement('p');
                    title.classList.add('title');
                    title.innerText = (factory.configs.protect)?$sce.trustAsHtml(factory.configs.title):factory.configs.title;
                    $return = title;
                } else {
                    $return = undefined;
                }
                return $return;
            },
            message: function(){
                if (typeof factory.configs.message !== "undefined" && typeof factory.configs.message != "object"){
                    var message = document.createElement('p');

                    if(factory.configs.protect){
                        message.innerText = $sce.trustAsHtml(factory.configs.message);
                    } else {
                        message.innerHTML = factory.configs.message;
                    }
                    return message;
                } else {
                    throw new Error("Notify Message can't be undefined")
                }
            },
            closer: function(){
                if(!factory.configs.buttons){
                    var icon = document.createElement('md-icon');
                        icon.innerText = 'close';
                    var closer = document.createElement('a');
                        closer.setAttribute('href', "javascript:void(0);");
                        closer.setAttribute('class', "notify-close");
                        closer.appendChild(icon);
                    return closer;
                }
            },
            buttons: function (){

                if(factory.configs.buttons) {
                    var row = document.createElement('div');
                    row.setAttribute('layout', 'row');
                    row.setAttribute('layout-align', 'center end');
                    row.classList.add('buttons');

                    if(factory.configs.confirmButtonShow){
                        var cco = factory.configs.confirmButtonClasses;
                        cco = (cco && typeof cco == "string") ? cco : cco.join(' ');

                        var btnConfirm = document.createElement('md-button');
                        btnConfirm.setAttribute('class', 'full-btn no-margin confirmButton ' + cco);
                        btnConfirm.innerText = factory.configs.confirmButtonText;

                        var flexConfirm = document.createElement('div');
                        flexConfirm.setAttribute('flex', '50');
                        flexConfirm.appendChild(btnConfirm);
                        row.appendChild(flexConfirm);
                    }

                    if(factory.configs.cancelButtonShow){
                        var ccl = factory.configs.cancelButtonClasses;
                        ccl = (ccl &&  typeof ccl == "string")?ccl:ccl.join(' ');

                        var btnClose = document.createElement('md-button');
                        btnClose.setAttribute('class', 'full-btn no-margin cancelButton '+ccl);
                        btnClose.innerText = factory.configs.cancelButtonText;

                        var flexClose = document.createElement('div');
                        flexClose.setAttribute('flex', '50');
                        flexClose.appendChild(btnClose);

                        row.appendChild(flexClose);
                    }

                    return row;
                }
            },
            body: function(){
                var icon = factory.Template.templates.icon();

                var flex = document.createElement('div');
                    flex.setAttribute('flex', (typeof icon != "undefined")?'80':'100');
                    flex.setAttribute('layout-align', 'start center');
                    flex.classList.add('inner');

                var closer = factory.Template.templates.closer();
                var title = factory.Template.templates.title();
                var message = factory.Template.templates.message();
                var buttons = factory.Template.templates.buttons();

                if (closer){ flex.appendChild(closer) }
                if (title){ flex.appendChild(title) }
                if (message){ flex.appendChild(message) }
                if (buttons){ flex.appendChild(buttons) }

                var layout = document.createElement('div');
                    layout.setAttribute('layout', "row");
                    layout.setAttribute('layout-align', 'start center');
                    layout.classList.add('content');

                if (typeof icon != "undefined"){
                    layout.appendChild(icon);
                }

                layout.appendChild(flex);

                return layout;
            }
        }
    };

    factory.create = function(){
        factory.hash(Util.randomChars(4));
        var filteredVal = factory.Params.filter(arguments);

        if(filteredVal != false && typeof filteredVal == "object"){

            var opts;
            if(filteredVal.type == "string"){
                opts = {message: filteredVal.val[0]};
            } else {
                opts = filteredVal.val[0];
            }


            factory.extendOptions(opts);
            factory.Template.setTemplate();
            factory.Events.setEvents();

            return factory;

        } else {
            console.error("Invalid notify options");
        }
    };

    factory.instance = {
        create: function (a, b, c) {
            return new notifyfab(a, b, c);
        },
        clear: factory.Clean.notify
    };

    return function(a, b, c){
        return new notifyfab(a, b, c);
    };
}]);

landing.controller('PackageController', ['$scope','$http','$window','Notify', function ($scope, $http,$window,Notify) {
 
    var updateMessage = function(notifyMessage, notifyStatus) {
        Notify(notifyMessage, notifyStatus);
    };

 
    $scope.package = function (package_type) {
        switch(package_type) {
            case 'pro':
                $scope.package_type = 1;
                $scope.package_pro = true;
                $scope.package_elite = false;
                $scope.package_legend = false;
                break;
            case 'elite':
                $scope.package_type = 2;
                $scope.package_elite = true;
                $scope.package_pro = false;
                $scope.package_legend = false;
                break;
            case 'legend':
                $scope.package_type = 3;
                $scope.package_legend = true;
                $scope.package_pro = false;
                $scope.package_elite = false;
                break;
        }

        $('#packageModal').modal('show');
    };

    $scope.submitPackage = function () {
        var request = {
            email: $scope.email,
            name: $scope.name,
            phone: $scope.phone,
            sport: $scope.sport,
            package_type: $scope.package_type,
            number_of_players: $scope.players,
            number_of_teams: $scope.teams,
            number_of_games_per_team: $scope.games_teams,
            address1: $scope.address1,
            address2: $scope.address2,
            organization: $scope.organization
        };
        
        $http({
          method  : 'POST',
          url     : '/api/package-requests',
          data    : request, 
         })
          .success(function(data) {
            // ngNotify.set('Package request is sent successfuly!','success');
            $('#packageModal').modal('hide');
            updateMessage('Package request is sent successfuly!','success');
            $window.location.reload();
          })
          .error(function (data) {
            updateMessage('Oops! Someting went wrong. Please try again','warning');
          });
    };

    $scope.customPackagePro = function () {
        $scope.package_type = 1;
        $scope.custom_elite = false;
        $scope.custom_legend = false;            
    };

    $scope.customPackageElite = function () {
        $scope.package_type = 2;
        $scope.custom_pro = false;
        $scope.custom_legend = false;            
    };

    $scope.customPackageLegend = function () {
        $scope.package_type = 3;
        $scope.custom_elite = false;
        $scope.custom_pro = false;            
    };

    $scope.submitCustomPackage = function () {
        $scope.custom.package_type = $scope.package_type;
        $scope.data = $scope.custom;
        
        $http({
          method  : 'POST',
          url     : '/api/package-requests',
          data    : $scope.data, 
          // headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
         })
          .success(function(data) {
            // ngNotify.set('Package request is sent successfuly!','success');
            $('#customModal').modal('hide');
            updateMessage('Package request is sent successfuly!','success');
            $window.location.reload();
          })
          .error(function (data) {
            updateMessage('Oops! Someting went wrong. Please try again','warning');
          });
    };

}]);

landing.controller('ContactController', ['$scope','$http','$window','Notify', function ($scope, $http,$window,Notify) {
    
    var updateMessage = function(notifyMessage, notifyStatus) {
        Notify(notifyMessage, notifyStatus);
    };
    
    $scope.submitContact = function () {
        $scope.data = $scope.contact;
        
        $http({
          method  : 'POST',
          url     : '/contact',
          data    : $scope.data, 
         })
          .success(function(data) {
            updateMessage('Contact request is sent successfuly!','success');
            $window.location.reload();
          })
          .error(function (data) {
            updateMessage('Oops! Someting went wrong. Please try again','warning');
          });
    };   
}]);

landing.controller('RefreesController', ['$scope','$http','$window','Notify', function ($scope, $http,$window,Notify) {

    var updateMessage = function(notifyMessage, notifyStatus) {
        Notify(notifyMessage, notifyStatus);
    };

    $scope.submitRequest = function (e) {
        e.preventDefault();
        $scope.refree.type = 3;
        $scope.data = $scope.refree;

        
        $http({
          method  : 'POST',
          url     : '/api/service-requests',
          data    : $scope.data, 
         })
          .success(function(data) {
            $('#myModal2').modal('hide');
            updateMessage('Referee demo request is sent successfuly!','success');
          })
          .error(function (data) {
            updateMessage('Oops! Someting went wrong. Please try again','warning');
          });
        return false;     
    };   
}]);

landing.controller('StatsController', ['$scope','$http','$window', function ($scope, $http,$window) {

    $scope.submitRequest = function () {
        $scope.request.type = 2;
        $scope.data = $scope.request;

        
        $http({
          method  : 'POST',
          url     : '/api/service-requests',
          data    : $scope.data, 
         })
          .success(function(data) {
            $window.location.reload();
          });
    };   
}]);

landing.controller('VideoController', ['$scope','$http','$window', function ($scope, $http,$window) {

    $scope.submitRequest = function () {
        $scope.request.type = 1;
        $scope.data = $scope.request;

        
        $http({
          method  : 'POST',
          url     : '/api/service-requests',
          data    : $scope.data, 
         })
          .success(function(data) {
            $window.location.reload();
          });
    };   
}]);

landing.controller('HeaderControllerStatic', ['$scope', '$http', '$q', '$stateParams', '$mdSidenav', '$mdBottomSheet', function ($scope, $http, $q, $stateParams, $mdSidenav, $mdBottomSheet) {

    $scope.showMobileMenu = function(){
        $mdSidenav('mobileMenu').toggle();
    };

    $scope.profileActions = [
        {
            icon: "dashboard",
            text: "Go to Dashboard",
            url: "#"
        },
        {
            icon: "edit",
            text: "Edit profile",
            url: "#"
        },
        {
            icon: "settings",
            text: "Security settings",
            url: "#"
        },
        {
            icon: "arrow_back",
            text: "Log out",
            url: "#"
        }
    ];
    $scope.$request = null;
    $scope.searchBar = {
        state: true,
        cache: false,
        Event: {
            search: function(query){

                var SearchDeferred = $q.defer();

                if($scope.search.params.search){
                    STORE('session', 'searchString', $scope.search.params.search);

                    if($scope.$request) { $scope.$request.abort() }

                    ($scope.$request = Autocomplete.getSearch($scope.search.params.search)).then(function(response){
                        var results = response.data;
                        console.log(results);
                        SearchDeferred.resolve(results);
                    }, function(response){
                        SearchDeferred.reject([]);
                    });
                }

                return SearchDeferred.promise;
            }
        },
        Object:{
            filter: function (query) {
                var lowercaseQuery = angular.lowercase(query);
                return function filterFn(state) {
                    return (state.name.indexOf(lowercaseQuery) === 0);
                };
            }
        }
    };

    $scope.showProfileActions = function($event){
        $('.can-no-z').addClass('no-z');
        $mdBottomSheet.show({
            templateUrl: bladeView('templates.layout.profileSheet'),
            controller: 'HeaderController',
            targetEvent: $event
        });
    };


    $scope.showMenu = function($mdOpenMenu, e) {
        $mdOpenMenu(e);
    };


    $scope.menu = {
        items:{
           
            company: [
                {
                    text: "Blog",
                    url: "https://wooter.co/blog"
                },
                {
                    text: "About",
                    url: "/about"
                },
                {
                    text: "Contact",
                    url: "/contact"
                },
                {
                    text: "Privacy Policy",
                    url: "/policy"
                },
                {
                    text: "Terms & Conditions",
                    url: "/terms"
                }
            ],
            
            services: [
                {
                    text: "Videos & Statistics",
                    url: "/packages"
                },
                {
                    text: "Custom Apparel",
                    url: "http://wooterapparel.com"
                },
                {
                    text: "Social Media Marketing",
                    url: "http://snapgrowmedia.com"
                },
                {
                    text: "Sports Insurance",
                    url: "/insurance"
                },
                {
                    text: "On Demand Video",
                    url: "https://michaelsisakov.wix.com/svcgroup"
                },
                {
                    text: "Referees",
                    url: "/referees"
                }
            ]
        }
    }
}]);

    