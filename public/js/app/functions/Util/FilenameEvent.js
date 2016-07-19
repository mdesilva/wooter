/*
 * Created by Dunitrana Alinus
 * User: alin.designstudio@gmail.com
 * For: Extensions
 * License: Wooter LLC.
 * Date: 2016.03.12
 * Description: Create filename Event from filename
 *              eg: path/to/filename.html => html:path.to.filename
 *
 */
"use strict";
function filenameEvent (include){
    include = removeExtension(include);
    include = include.replace('views/default/', '');
    include = include.split('/').join('.');
    return include;
}

function includeLoaded(filename){
    if(angular.isArray(filename) || angular.isString(filename)){
        if(angular.isArray(filename)){
            var events = angular.fromJson($$store.session.get('include_events'));
            var unloaded = [];

            angular.forEach(filename, function(v){
                var event = filenameEvent(v);
                if(!(events.indexOf(event) > -1)){
                    unloaded.push(event);
                }
            });

            return (count(unloaded) == 0);
        } else {
            return (angular.fromJson($$store.session.get('include_events')).indexOf(filenameEvent(filename)) > -1);
        }
    } else {
        return false;
    }
}