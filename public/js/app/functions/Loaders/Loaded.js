/**
 * Created by Dumitrana Alinus.
 * User: alin.designstudio@gmail.com
 * For: Loaders
 * License: Wooter LLC.
 * Date: 2016.04.12
 * Description: remove loading class to body to hide default loader
 *
 */
"use strict";
function loaded () {
    document.body.classList.remove('page--loading');
}
