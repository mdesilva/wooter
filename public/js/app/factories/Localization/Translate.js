/*
 * Created by {your name}.
 * User: {slack, skype}
 * For: {package}
 * License: Wooter LLC.
 * Date: 2015.12.31
 * Description:
 *
 */
__Wooter.factory('TRANS', ['$window', '$http', '$q', function($window, $http, $q){
    var factory = {};

    factory.language = getMeta('lang');
    factory.locale = getMeta('locale');
    factory.languages = getMeta('availible_languages');
    factory.trans = getMeta('trans');

    factory.pluralization = function(instance, no){
        var instances = (instance.split('|'))?instance.split('|'):false;

        if (instances) {
            if(instances.length == 1){
                return instances[0];
            }

            if(instances.length == 2){
                if(parseInt(no) > 1){
                    return instances[1];
                } else{
                    return instances[0];
                }
            }

            if(instances.length == 3){
                if(parseInt(no) == 0){
                    return instances[0];
                } else{
                    if (parseInt(no) == 1) {
                        return instances[1];
                    } else {
                        return instances[2];
                    };
                }
            }
        };
    };

    factory.compile = function(tpl, data){

        var $tpl = tpl;

        angular.forEach(data, function(val, key){
            $tpl = $tpl.split(":"+key);
            $tpl = $tpl.join(val);
        });

        return $tpl;

    }

    factory.translate = function(trans, data, no){
        var $trans = (factory.trans[trans])?factory.trans[trans]:factory.locale[trans];

        if (typeof data != 'undefined') {
            if (typeof data == 'number') {
                $trans = factory.pluralization($trans, data);
            }

            if (typeof data == 'array' || typeof data == 'object') {
                $trans = factory.compile($trans, data);
                if (typeof no == 'number' && typeof no != 'undefined') {
                    $trans = factory.pluralization($trans, no);
                }
            }
        }

        return $trans;
    };

    return factory;
}]);