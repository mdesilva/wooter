/**
 * Created by Dumitrana Alinus.
 * User: alin.designstudio@gmail.com
 * For: Numbers Convert
 * License: Wooter LLC.
 * Date: 2016.04.27
 * Description: put "9" to "09"
 *
 */
"use strict";
function twoDigit (val, absolute) {
	absolute = (absolute)?true:false;
	val = (absolute)?val:Math.abs(val);
	val = (val < 10)?"0"+val:""+val;
	
    return val;
}
