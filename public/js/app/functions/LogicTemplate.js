/*
 * Created by Dumitrana Alinus.
 * User: alin.designstudio
 * For: Templating
 * License: Wooter LLC.
 * Date: 2016.01.31
 * Description: creating a path to angular view acording device type requested
 *
 */
"use strict";
function logicTemplate ($tpl, $fstate) {
    var $this;

    $this = {
        forcedState: false,
        device: getMeta('deviceInfo'),
        views: getMeta('view_cache'),
        checkTemplate: function ($tpl) {
            return !!($this.views[$tpl] != null || $this.views[$tpl] != undefined);
        },

        getTemplate: function ($tpl) {
            if($this.checkTemplate($tpl)){
                return 'views/'+$this.getLayoutMode($tpl)+'/'+$tpl;
            } else {
                return 'views/default/'+$tpl;
            }
        },
        getModes: function ($tpl) {
            return $this.views[$tpl];
        },
        getLayoutMode: function($tpl){
            var $modes = $this.getModes($tpl);
            var $device;

            if(!$this.forcedState){
                if($modes['default'] && $modes['tablet'] && $modes['mobile']){
                    $device = $this.device.device;
                }

                if($modes['default'] && !$modes['tablet'] && $modes['mobile']){
                    if($this.device.device == 'tablet'){
                        $device = 'mobile';
                    } else {
                        $device = $this.device.device;
                    }
                }

                if($modes['default'] && !$modes['tablet'] && !$modes['mobile']){
                    $device = 'default';
                }
            } else {
                $device = $this.forcedState;
            }

            return ($device == 'desktop')?'default':$device;
        }
    };



    return (function ($tpl, $sparam) {
        $tpl = $tpl.split('.html').join('')+'.html';
        if($sparam && typeof $sparam == 'string'){
            if($sparam == 'default' || $sparam == 'desktop' || $sparam == 'tablet' || $sparam == 'mobile'){
                $this.forcedState = $sparam;
            } else {
                console.error('Argument value bad ('+$sparam+'). Argument 2 need to be default, desktop, tablet or mobile!');
            }
        }
        return $this.getTemplate($tpl);
    })($tpl, $fstate);
}
