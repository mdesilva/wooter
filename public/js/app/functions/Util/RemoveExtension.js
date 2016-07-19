/*
 * Created by Dunitrana Alinus
 * User: alin.designstudio@gmail.com
 * For: Extensions
 * License: Wooter LLC.
 * Date: 2016.03.12
 * Description: remove, add extension for an filename
 *
 */
"use strict";
function getExtensions (){
    return ['.html', '.js', '.svg', '.css'];
}
function removeExtension (filename) {
    filename = filename.split('.');
    var extension = filename[count(filename)-1];
    filename = filename.join('.').replace('.'+extension,'');

    return extension+':'+filename;
}

function addExtension (filename) {
    console.assert(typeof filename == "string", "Value need to be valid string");
    if(typeof filename == "string"){
        filename = filename.split(':');
        console.assert(count(filename) == 2, "Value need to be valid format ( [extension]:[filename] )");
        if(count(filename) == 2){
            return filename[1] + '.' + filename[0];
        }
    }

}
