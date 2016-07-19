/*
 * Created by Dumitrana Alinus
 * User: alin.designstudio
 * For: svg manipulator
 * License: Wooter LLC.
 * Date: 2016.03.02
 * Description: get svg with favorite color
 *
 */
"use strict";
/**
 * Function to control SVG files
 *
 * @param {string} file path to svg file
 * @param {string} fromColor color from svg
 * @param {string} toColor color who will replace the color from svg
 *
 * @return {string}
 */
function svg (file, fromColor, toColor) {
    var $this;
    var fcol, tcol;

    /*
     * Define Colors Values
     */
    if(fromColor){
        fcol = (toColor)?fromColor:'000';
        tcol = (toColor)?toColor:fromColor;
    } else {
        fcol = null;
        tcol = null;
    }

    /*
     * Functions Object
     */
    $this = {
        /*
         * Initializer
         */
        init: function(file, f, t){
            var link = '/api/svg/{file}{fromColor}{toColor}';

            /*
             * Compile the path
             * EG: 'icons/leagues/person.svg' -> icons.leagues.person
             */
            file = file.replace('.svg','');
            file = file.split('/').join('.');

            var vars = {
                file: file,
                fromColor: (f)?'/'+f:'',
                toColor: (t)?'/'+t:''
            };


            return tpl(link, vars).split('#').join('');
        }
    };

    return $this.init(file, fcol, tcol);
}
