/*
 * Created by Dumitrana Alinus
 * User: alin.designstudio
 * For: Template system
 * License: Wooter LLC.
 * Date: 2016.01.25
 * Description: Get Blade views helper
 *
 */
"use strict";
function bladeView (view) {
    var $this;

    $this = {
        init: function(data){
            data = $this.cleanSlash(data);
            var $tpl = tpl($this.bladeURL, {
                view: data
            });

            return $tpl;
        },
        bladeURL: "/api/view/{view}",
        cleanSlash: function(str){
            return str.split('//').join('.').split('/').join('.');
        }
    };

    return $this.init(view);
}