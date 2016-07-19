/*
 * Created by {your name}.
 * User: {slack, skype}
 * For: {package}
 * License: Wooter LLC.
 * Date: 2016.03.15
 * Description:
 *
 */
"use strict";
function range (a, b) {
    var $ret = [];

    a = (b)?a:0;
    b = (b)?b:a;

    for(var i = a; i <= b; i++){
        $ret.push(i);
    }

    return $ret;
}
