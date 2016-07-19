var error = {
	jquery: '<body id="app_bus"><p>App not ready, try again later!</p></body>'
};

var config = {
	__token : $('meta[name="__token"]').attr('content'),
	colors : ['16a085','2ecc71','27ae60','3498db','2980b9','34495e','2c3e50','ea4c88','ca2c68','9b59b6','8e44ad','f1c40f','f39c12','e74c3c','c0392b','bdc3c7','95a5a6','7f8c8d']
};

/**
 * Check ECMAScript(ES6) support
 * @returns {boolean}
 */
function check_es6() {
	"use strict";
	try {
		eval("var foo = (x)=>x+1");
	} catch (e) {
		return false;
	}
	return true;
}

function exist_jquery () {
	if (typeof jQuery != 'undefined') {
		return true;
	} else {
        throw new Error('Error: jQuery is not defined!');
	}
}

function support_es6() {
	if(check_es6()) {
        document.cookie = "es6=true";
        return true;
    } else {
        document.cookie = "es6=false";
        throw  new Error('Error: ES6 Not supported!');
    }
}

function validate_page(){
	try {
        exist_jquery();
        support_es6();
    } catch (e) {
        return false;
    }
    return true;
}

function $config(name){
	return config[name];
}

$.ajaxSetup({
	headers: {
		'X-CSRF-TOKEN': $config('__token')
	},
    beforeSend: function (xhr) {
        if('satellizer_token' in localStorage){
            xhr.setRequestHeader('Authorization', "Bearer " + localStorage.satellizer_token);
        }
    },
	fail: function(e){
		console.log(e);
	}
});

/*
 * Prototyping
 *
 * toUnderscore -> to_underscore
 */
String.prototype.toUnderscore = function(){
	return this.replace(/([A-Z])/g, function($1){return "_"+$1.toLowerCase();});
};

/*
 * toDash -> to-dash
 */
String.prototype.toDash = function(){
	return this.replace(/([A-Z])/g, function($1){return "-"+$1.toLowerCase();});
};

Date.prototype.getUnix = function(){
    return Math.floor(this.getTime()/1000);
};
