/**
 * Check Type of data value
 *
 * @param data
 * @param type
 * @returns {boolean}
 */
function check_type(data,type){
	return (typeof data == type);
}

/**
 * Little string template system
 *
 * @param $tpl
 * @param $data
 * @returns {*}
 */
function tpl($tpl, $data) {
	$tpl = $tpl.toString();
	var $keys = Object.keys($data);
	$.each($keys, function(index, val) {
		var $key = "{" + val + "}";
		$tpl = $tpl.split($key);
		$tpl = $tpl.join($data[val]);
	});
	return $tpl;
}

/**
 * Fit images to parent based on width and height
 * @param img
 */
function resizeImage(img){
	var size = { width: img.width, height: img.height };
	var cases = {
		square: function(im){
			im.style.width = '100%';
			im.style.height = '100%';
		},
		landscape: function(im){
			im.style.width = 'auto';
			im.style.height = '100%';
		},
		portrait: function(im){
			im.style.width = '100%';
			im.style.height = 'auto';
		}
	};
	if (size.width == size.height) {
		cases.square(img);
	} else if(size.width > size.height){
		cases.landscape(img);
	} else {
		cases.portrait(img);
	}
	img.parentElement.classList.add('half');
	setTimeout(function(){
		img.parentElement.classList.remove('half');
		img.parentElement.classList.add('loaded');
	}, 1000);
}

function maskBlur($check, $func){
	var searchElement, dofunc;
	var $defmask = '.md-scroll-mask';

	$func = ($func)?$func:function(){};

	if ($check) {
		switch(typeof $check){
			case 'string':
				searchElement = ($check)?$check:$defmask;
				dofunc = $funcl;
				break;
			case 'function':
				searchElement = $defmask;
				dofunc = $check;
				break;
		}
	} else {
		searchElement = $defmask;
		dofunc = function(){};
	}

	var body = document.querySelector('body');
		body.classList.add('blur');

	var intv = setInterval(function(){
		if (!check_element(searchElement)) {
			dofunc();
			body.classList.remove('blur');
			clearInterval(intv);
		}
	}, 100);
}

/**
 * Get function name
 * @param fun
 * @returns {*}
 */
function funcName(fun) {
	var ret = fun.toString();
	ret = ret.substr('function '.length);
	ret = ret.substr(0, ret.indexOf('('));
	return ret;
}

/**
 * Check if element exist
 *
 * @param $element
 * @returns {boolean}
 */
function check_element ($element) {
	return (document.querySelector($element) != null);
}

/**
 * redirect to other page
 * @param link
 */
function redirect(link) {
	var host = window.location.origin;
	var $link = link.replace(host, '');
	if($link.charAt(0) == '/'){
		$link = $link.substr(1);
	}
	$link = host+'/'+$link;
	
	window.location = $link;
}

/**
 * Uppercase first char
 * @param $str
 * @returns {string}
 */
function capitalize($str){
	return $str.charAt(0).toUpperCase()+$str.slice(1);
}

/**
 * Get angular controller name
 * Auto name Cleaner
 *
 * @param $name
 * @param $as
 * @returns {string}
 */
function getControllerName($name, $as){
	$name = $name.split('.js').join('').split('/');
	for(var i=0; i<$name.length; i++){
		$name[i] = capitalize($name[i]);
	}

	$as = ($as)?" as "+$as.toString():"";
	return $name.join('/')+$as;
}

/**
 * Some Utilities
 * @constructor
 */
function Utilities (){
	var $self = this;
	this.bg = function ($parent) {
		$parent.each(function(){ $(this).css('background-image', 'url('+$(this).attr('data-bg')+')').removeAttr('data-bg') });
	};
	this.random_bg = function($parent){
		$($parent).css('background', $self.random_color);
	};
	this.random_color = function(){
		return '#'+$config('colors')[Math.floor(Math.random()*$config('colors').length)];
	};
	this.animated_bg = function ($parent) {
		var $duration = ($parent.attr('data-animated-bg'))?$parent.attr('data-animated-bg'):5000;
		setTimeout(function(){
			$self.random_bg($parent);
			var interval = setInterval(function(){
				$self.random_bg($parent);
			}, $duration);
		}, 500);
	};
	this.animated_color = function ($parent, $duration, func) {
		$duration = ($duration) ? $duration : 5000;
		var color = $self.random_color();
		setTimeout(function(){
			func($parent, color);
			var interval = setInterval(function(){
				var color = $self.random_color();
				func($parent, color);
			}, $duration);
		}, 500);
	};
	this.colorConvert = function(hex, opacity){
	    hex = hex.replace('#','');
	    var r = parseInt(hex.substring(0,2), 16);
	    var g = parseInt(hex.substring(2,4), 16);
	    var b = parseInt(hex.substring(4,6), 16);

	    return 'rgba('+r+','+g+','+b+','+opacity/100+')';
	};
	this.color_long = function (color){
		color = color.replace('#', '');
		var $color = color;
		if ($color.length == 3) {
			$color = '#'+color[0]+''+color[0]+''+color[1]+''+color[1]+''+color[2]+''+color[2];
		}
		return $color;
	};
	this.random = function (n){
		var text = "";
		var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
		for( var i=0; i < n; i++ )
			text += possible.charAt(Math.floor(Math.random() * possible.length));
		return text;
	};
}

/**
 * Encode object to URL params
 * eg: {foo:1, bar:2} => foo=1&bar=2
 *
 * @like : $.params()
 * @param data
 * @returns {*}
 */
function serializeObject (data){
	if ( typeof data != "object" ) { return( ( data == null ) ? "" : data.toString() ); }

	var buffer = [];
	for ( var name in data ) {
        if ( ! data.hasOwnProperty( name ) ) { continue; }
        var value = data[ name ];
        buffer.push( encodeURIComponent( name ) + "=" + encodeURIComponent( ( value == null ) ? "" : value ) );
    }
    var source = buffer.join( "&" ).replace( /%20/g, "+" );
    return (source);
}

/**
 * Get length of an object or an array
 *
 * @param $object
 * @returns {number}
 */
function getLength ($object){
    var $k = 0;
    if ($object) {
        if(check_type($object,'object') || check_type($object,'string')){
            for(var i in $object){
                $k += 1;
            }
        }
    }
    return $k;
}

/**
 * Get length of an object or an array
 * @param a
 * @returns {number}
 */
function count (a){
    return getLength(a);
}

/**
 * Clean url/string with more slashes
 * eg: path/////to//our/link////////are///////here/ => path/to/our/link/are/here
 * @param $str
 * @returns {*}
 */
function cleanSlashes($str){
    while(count($str.split("//")) > 1){
        $str = $str.split('//').join('/');
    }
    return $str;
}


/**
 * Check if string is JSON
 *
 * @source http://stackoverflow.com/questions/3710204/how-to-check-if-a-string-is-a-valid-json-string-in-javascript-without-using-try
 * @param text
 * @returns {boolean}
 */
function isJSON(text){
    return (/^[\],:{}\s]*$/.test(text.replace(/\\["\\\/bfnrtu]/g, '@').replace(/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g, ']').replace(/(?:^|:|,)(?:\s*\[)+/g, ''))) ? true : false;
}

/**
 * Check if is Null
 *
 * @param val
 * @returns {boolean}
 */
function isNull(val){
    return !!(val === null && typeof val === "object");
}

/**
 * Check if is boolean
 *
 * @param val
 * @returns {boolean|*}
 */
function isBool(val){

    switch (typeof val){
        case "string":
            $return = !!(val.trim().toLowerCase() == 'true' || val.trim().toLowerCase() == 'false');
            break;
        case "boolean":
            $return = true;
            break;
        default :
            $return = false;
    }

    return $return;
}

var UI = new Utilities();

function Engine(){}

/**
 * @update store method
 * @v1.0 store method using window object
 * @v2.0 store method using sessionStorage
 * @version 2.0
 */
(function setMeta () {
    var $meta = document.querySelectorAll('meta[name]');
    var $items = 0;
    angular.forEach($meta, function(value){
        /*
         * Store name and content of item
         */
        var name = value.getAttribute('name');
        var content = value.getAttribute('content');
        if (name.substr(0,2) == '__') {
            sessionStorage.setItem(name, content.toString());
            $items += 1;
            value.remove();
        }
        sessionStorage.setItem('__length', $items);
    });
})();

/**
 * Get Meta from storage
 *
 * @param meta
 * @returns {*}
 */
function getMeta(meta){
    var val = sessionStorage.getItem('__'+meta.toString());
    var content = null;
    if(!isNull(val)){
        content = val;
        if (isJSON(content)){
            content = angular.fromJson(content);
        } else {
            if (isBool(content)){
                content = angular.fromJson("["+content+"]");
            }
        }
    }
    return content;
}
