/**
 * Created by Dumitrana Alinus.
 * User: alinus
 * For: Templating routes
 * License: Wooter LLC.
 * Date: 26.12.2015
 * Description: If $tpl value is a string will be considered name of
 *              template and will load default template for header and footer
 *              and main template will be $tpl value.
 *              If $tpl value is an array will be considered object views and
 *              will return the object
 */
function templater($tpl, $controller, $m){
    var getResolve = function(mdl){
        var $ret = {};
        if(mdl){
            if(check_type(mdl,'object')){
                angular.forEach(mdl, function (val, key) {
                    if(key == parseInt(key)){
                        $ret[val] = $middleware(val);
                    } else {
                        $ret[key] = ($middleware(val))?$middleware(val):val;
                    }
                })
            } else {
                if(check_type(mdl,'string') && $middleware(mdl)){
                    $ret[mdl] = $middleware(mdl)
                }
            }
        }
        return $ret;
    };

    if(typeof $tpl == 'string'){
        return {
            "main": {
                templateUrl: logicTemplate($tpl),
                controller:  getControllerName($controller),
                resolve: getResolve($m)
            }
        }
    } else {
        return $tpl;
    }
}
