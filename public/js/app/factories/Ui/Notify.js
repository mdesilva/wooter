/*
 * Created by Dumitrana Alinus,
 * User: alin.designstudio - skype
 * For: UI/Notifications
 * License: Wooter LLC.
 * Date: 2016.01.07
 * Description: small plugin to create a notifications
 *
 */
__Wooter.factory('Notify', ['$window', 'Util', '$compile', '$sce', "$rootScope", 'Page', '$timeout', function($window, Util, $compile, $sce, $rootScope, Page, $timeout){
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

