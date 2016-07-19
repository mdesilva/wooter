"use strict";
var fs = require('fs');
var object_dispatcher = {};
var marked = require('marked');

object_dispatcher.getFile = function(){
    return fs.readFileSync('./routes.tmp').toString();
};

object_dispatcher.dispatchFile = function(){
    var content = object_dispatcher.getFile();
    var lines = content.split('\r\n');
    delete lines[0];

    var len = lines.length;

    lines[2] = lines[2].split('+').join(' | ');
    delete lines[len-2];
    return lines.join('\r\n');

};

object_dispatcher.getTPL = function(){
    return fs.readFileSync('./nodejs/routes_dispatcher/route_tpl.html').toString();
};

object_dispatcher.put = function(content){
    return object_dispatcher.getTPL().replace('@@content', content);
};

object_dispatcher.compile = function(){
    var dispatch = object_dispatcher.dispatchFile();
    marked.setOptions({
        renderer: new marked.Renderer(),
        gfm: true,
        tables: true,
        breaks: false,
        pedantic: false,
        sanitize: true,
        smartLists: true,
        smartypants: false
    });

    var content = marked(dispatch)
        .split('[39m')
        .join('')
        .split('[32m')
        .join('')
        .replace(/\s+/g, '');

    var regz = /(?:{)((?:[A-Za-z]+)(?:\.(?:[A-Za-z]+))*)(?:})/g;
    var arrs = [];

    while(regz.exec(content) != null){
        var indexs = regz.exec(content);

        if(indexs != null){
            arrs.push(indexs[0]);
        }
    }

    for(var arr in arrs){
        var val = arrs[arr];
        content = content.split(val).join('<span class="paramID">'+val+'</span>');
    }

    content = content.split('<table>').join('<table class="table table-hover">');
    return object_dispatcher.put(content);
};
module.exports = function (){
    return object_dispatcher;
};