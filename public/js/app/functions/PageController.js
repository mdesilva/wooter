/*
 * Created by Dumitrana Alinus.
 * User: alinus
 * For: Templating routes
 * License: Wooter LLC.
 * Date: 2016.01.06
 * Description: return just a object for pages
 *
 */
"use strict";
function pageController (url, controller) {
    var $this;

    $this = {
        url: url,
        views: {
            main: {
                controller: controller
            }
        }
    };

    return $this;
}
