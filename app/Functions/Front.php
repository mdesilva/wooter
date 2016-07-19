<?php
use Illuminate\Support\Facades\Storage;
use Jenssegers\Agent\Agent;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * Flash messages loader
 * This function require config/flash_messages.php
 * This function return value of message code (FlashMessage('code'))
 * or array with all code and message if input is array (FlashMessage(['code, 'code']))
 *
 * @param string/int/array $code
 * @return string/array
 * @author Alinus (alin.designstudio => skype)
 **/
function FlashMessage($code) {
	$messages = config('flash_messages');
	$return   = [];
	if (is_array($code)) {
		foreach ($code as $value) {
			$return[$value] = $messages[$value];
		}
	} else {
		$return = $messages[$code];
	}

	return $return;
}

/**
 * Angular scripts helper
 * This function require config/front_end.php
 * This function check if module exist in config/front_end.php => angular_modules
 * If input is a array with module return true if all module exist or array with all 
 * missed modules
 *
 * @param string/array $code
 * @return string/array/boolean
 * @author Alinus (alin.designstudio => skype)
 **/
function angular_check_module($mod){
	$return = [
		'modules' => [],
		'found' => 0,
		'not_found' => 0
	];
	if (is_array($mod)) {
		foreach ($mod as $value) {
            $file = '/public/js/vendors/angular/angular-'.$value.'.js';
            $cond = file_exists(base_path($file));
			if(!$cond){
				$return['modules'][] .= $value;
				$return['not_found'] += 1;
			}
		}
		if($return['not_found'] == 0){
			$return = true;
		} else {
			$return = $return['modules'];
		}
	} else {
        $file = '/public/js/vendors/angular/angular-'.$mod.'.js';
        $cond = file_exists(base_path($file));
		if($cond){
            $return = true;
        } else {
            $return = false;
		}
	}
	return $return;
}

/**
 * Angular scripts helper
 * This function require config/front_end.php
 * This function return element script based on angular modules
 * eg: angular()
 *     angular(true)
 *     angular(false)
 *     angular('route')
 *     angular(['route', 'animate']) this will return 2 script element with path to angular-route.js
 *     and angular-animate.js
 *
 * If angular doesn't exist into config/front_end.php => angular_modules, this function will return
 * <script type="text/javascript">console.error("Error: Angular plugin angular-[module].js, don\'t exist!")</script>
 *
 * @param string/array $module
 * @return string
 * @author Alinus (alin.designstudio => skype)
 **/
function angular($module = '') {
	$return = '';
	$angular_path = config('front_end.path.angular.angular');
	if (is_array($module)) {
		$return = '';
		foreach ($module as $mod) {
            $file = $angular_path.'/angular-'.$mod.'.js';
			if ($mod == 'angular' || $mod == "angular.js") {
				$return .= '<script src="'.$angular_path.'/angular.js" type="text/javascript"></script>';
			} else {
				if (substr($mod, -3) == '.js') {
					$mod = substr($mod, 0, -3);
				}
				if(angular_check_module($mod)){
					$return .= '<script src="'.$file.'" type="text/javascript"></script>';
				} else {
					$return .= '<script type="text/javascript">console.error("Error: Angular plugin '.$file.', don\'t exist!")</script>';
				}
			}
		}
	}
	if (is_bool($module)) {
		if ($module) {
			$return = '<script src="'.$angular_path.'/angular.js" type="text/javascript"></script>';
		} else {
			$return = '';
		}
	}
	if (is_string($module)) {
		if ($module == '' || $module == 'angular' || $module == "angular.js") {
			$return = '<script src="'.$angular_path.'/angular.js" type="text/javascript"></script>';
		} else {
			if (substr($module, -3) == '.js') {
				$module = substr($module, 0, -3);
			}
			if(angular_check_module($module)){
				$return = '<script src="'.$angular_path.'/angular-'.$module.'.js" type="text/javascript"></script>';
			} else {
				$return .= '<script type="text/javascript">console.error("Error: Angular plugin \'angular-'.$module.'.js\' don\'t exist!")</script>';
			}
		}
	}
	return $return;
}

/**
 * Enviroment helper
 * This function will return a boolean value base on .envs => APP_ENV
 * This will interogate if APP_ENV is equal with input value
 *
 * @param string $env
 * @return boolean
 * @author Alinus (alin.designstudio => skype)
 **/
function detectEnvironment($env = 'local') {
	return (env('APP_ENV', 'production') == $env) ? true : false;
}

/**
 * Font-Awesome helper
 * This generate one element
 * eg: fa('plus', 'span') this will print <span class="fa fa-plus"></span>
 * eg: fa('plus', 'span', ['role'=>'icon']) this will print <span class="fa fa-plus" role="icon"></span>
 *
 * @param string $icon
 * @param string $element
 * @param string/array $attr
 * @return string
 * @author Alinus (alin.designstudio => skype)
 **/
function fa($icon, $element = null, $attr = null) {
	$render = '';
	
	if (is_null($element) && is_null($attr)) {
		$render = '<i class="fa fa-' . $icon . '"></i>';
	} else {
		if (!is_null($element)) {
			$render = '<' . $element;
		} else {
			$render = '<i';
		}
		if (!is_null($attr)) {
			if (is_array($attr)) {
				if (!empty($attr['class'])) {
					$render .= ' class="fa fa-' . $icon . ' ' . $attr['class'] . '"';
				} else {
					$render .= ' class="fa fa-' . $icon . '"';
				}
				foreach ($attr as $index => $val) {
					if ($index != 'class') {
						$render .= ' ' . $index . '="' . $val . '"';
					}
				}
			} else {
				$render .= ' ' . $attr;
			}
		} else {
			$render .= ' class="fa fa-' . $icon . '"';
		}
		if (!is_null($element)) {
			$render .= '></' . $element . '>';
		} else {
			$render .= '></i>';
		}
	}
	
	return $render;
}

/**
 * Loader helper
 * This generate one element with svgloader structure
 *
 * @param string $loader
 * @param string $color
 * @param string $element
 * @param string $class
 * @return string
 * @author Alinus (alin.designstudio => skype)
 **/
function svg_loader($loader, $color = '#fff', $element = null, $class = null, $inner=null) {
	
	$element = (is_null($element))?'span':$element;
	$class = (is_null($class))?'':' '.$class;
	$inner = (is_null($inner))?'':$inner;
	$loader = (substr($loader, -4) == '.svg')?substr($loader, 0, -4):$loader;


	$img_path =  config('front_end.path.loaders').'/loader-'.$loader.'.svg';
	$img = ($color != '#fff')?implode($color, explode('#fff', Storage::get($img_path))):Storage::get($img_path);

	
	$render = '<'.$element.' class="loader'.$class.'"><div class="inner"><span class="svg_img">'.$img.'</span>'.$inner.'</div></'.$element.'>';
	
	return $render;
}

/**
 * Svg helper
 * This generate svg string
 *
 * @param string $loader
 * @param string $path
 * @param string $color
 * @param string $class
 * @return string
 * @author Alinus (alin.designstudio => skype)
 **/
function svg($file, $path = null, $color = '#fff', $class = null) {

	$path = (is_null($path))?'':(substr($path, -1) == '/')?substr($path, 0, -1):$path.'/';
	$class = (is_null($class))?'':' '.$class;
	$file = (substr($file, -4) == '.svg')?substr($file, 0, -4):$file;


	$svg_path =  config('front_end.path.svg').'/'.$path.''.$file.'.svg';
	$svg = ($color != '#fff')?implode($color, explode('#fff', Storage::get($svg_path))):Storage::get($svg_path);

	
	$render = $svg;
	
	return $render;
}

/**
 * entypo helper
 * This generate entypo icon as <span class="entypo svg_img [class]">[svg]</span>
 *
 * @param string $loader
 * @param string $color
 * @param string $class
 * @return string
 * @author Alinus (alin.designstudio => skype)
 **/
function entypo($file, $color = '#fff', $class = null) {

	$class = (is_null($class))?'':' '.$class;
	$file = (substr($file, -4) == '.svg')?substr($file, 0, -4):$file;

	$svg = svg($file, 'icons/entypo', $color, $class);

	
	$render = '<span class="entypo svg_img'.$class.'">'.$svg.'</span>';
	
	return $render;
}

/**
 * Input helper
 * This will check the new or old (if new are null) values if exist into an array with datas;
 *
 * eg: inputCheck('vendor', '', 'checked', ['user'], ['player'])
 * This will not print anything, why?
 * $new value is equal with vendor $data_s is set so all checks for new value will check on
 * $data_s array, this example have only player on array so condition will return ""
 * 
 * eg: inputCheck('user', '', 'checked', ['user']) will return 'checked'
 * eg: inputCheck('user', '', 'checked', ['user'], ['vendor']) will return ''
 * eg: inputCheck( null, 'vendor', 'checked', ['user'], ['vendor']) will return ''
 * eg: inputCheck( null, 'vendor', 'checked', ['vendor', 'player']) will return 'checked'
 *
 * @param string $new
 * @param string $old
 * @param string $val
 * @param array $data array to check $old and $new values
 * @param array $data_s array to check only $new value
 * @return string
 * @author Alinus (alin.designstudio => skype)
 **/
function check_vals($new, $old, $val, $data = [], $data_s = []) {
	$return = '';
	if(is_null($new)){
		if(is_array($data) && sizeof($data) > 0){
			$cond = array_search($old, $data);
			if($cond || (string)$cond  == '0'){
				$return = $val;
			} else {
				$return = "";
			}
		} else {
			if($old){
				$return = $val;
			} else {
				$return = "";
			}
		}
	} else {
		if(is_array($data) && sizeof($data) > 0){
			if(is_array($data_s) && sizeof($data_s) > 0){
				$temp = $data_s;
			} else {
				$temp = $data;
			}
			$cond = array_search($new, $temp);
			if($cond || (string)$cond  == '0'){
				$return = $val;
			} else {
				$return = "";
			}
		} else {
			if($new){
				$return = $val;
			} else {
				$return = "";
			}
		}
	}
	return $return;
}

/**
 * get lang helper
 * This will return language
 *
 *
 * @return string
 * @author Alinus (alin.designstudio => skype)
 **/
function getLang() {
	if (request()->cookie(config('translate.su_cookie_name'))) {
		$cookie = request()->cookie(config('translate.su_cookie_name'));
	} else {
		if (request()->cookie(config('translate.cookie_name'))) {
			$cookie = request()->cookie(config('translate.cookie_name'));
		} else {
			if (substr(request()->server('HTTP_ACCEPT_LANGUAGE'), 0, 2)) {
				$cookie = substr(request()->server('HTTP_ACCEPT_LANGUAGE'), 0, 2);
			} else {
				$cookie = config('translate.default_locale');
			}
		}
	}
	return $cookie;
}

/**
 * get trans helper
 * This will return translates
 *
 *
 * @param boolean/string
 * @return string
 * @author Alinus (alin.designstudio => skype)
 **/
function getTrans($locale = true) {
	$dir = Storage::directories('config/translate');
	$return = null;
	$langs = [];
	foreach ($dir as $val) {
		$langs[substr($val, -2)] = Storage::allFiles('config/translate/'.substr($val, -2));
	}

	foreach ($langs as $lang_k => $lang) {
		foreach ($lang as $j => $value) {
			$key = 'config/translate/'.substr($lang_k, -2);
			$key = explode($key, $value)[1];
			$key = implode('.', explode('/', substr(substr($key, 0, -5), 1)));

			$data = trim(Storage::get($value));
			$data = json_decode($data, true);
			$data = array_dot($data);

			$langs[$lang_k][$key] = $data;
			unset($langs[$lang_k][$j]);
		}
	}

	if (!$locale) {
		$return = array_dot($langs);
	} else {
		if (is_bool($locale)) {
			$return = array_dot($langs[getLang()]);
		} else {
			$return = array_dot($langs[$locale]);
		}
	}

	return json_encode(array_dot($return));
}

/**
 * Device Info Helper
 * This will return information of request device
 *
 * @return array
 * @author Alinus (alin.designstudio => skype)
 **/
function deviceInfo() {
    $agent = new Agent();
    $device = '';

    if(!request()->cookie('forced-desktop')){
        if($agent->isDesktop()){
            $device = 'desktop';
        } elseif ($agent->isTablet()){
            $device = 'tablet';
        } elseif ($agent->isMobile()) {
            $device = 'mobile';
        } else {
            $device = 'desktop';
        }
    } else {
        $device = 'desktop';
    }

    $info = [
        'name' => $agent->device(),
        'browser' => $agent->browser(),
        'platform' => $agent->platform(),
        'device' => $device,
        'robot' => $agent->isRobot()
    ];

    return $info;
}

// multiple debugger
function ddd($data, $v = false){
    if (is_array($data)) {
        print_r("<script>console.log($.parseJSON('".json_encode($data)."'))</script>");
    } else {
        print_r('<script>console.log("'.gettype($data).' => '.$data.'")</script>');
    }
    echo "<pre>";
    if ($v) { var_dump($data); } else { print_r($data); }
    echo "</pre>";
}

/**
 * This is a helper to compile a string
 *
 * tpl('Hello {{name}}!', ['name' => 'World']) => 'Hello World!'
 *
 * @param string $string
 * @param array $data
 * @return string
 */
function tpl($string, $data = []){

    foreach($data as $key => $value){
        $string = implode($value, explode("{{{$key}}}", $string));
    }

    return $string;
}

/**
 * Get content of json from config/*.json
 *
 * jsonConfig('css')
 *
 * @param string $cfg
 * @return array
 */
function jsonConfig($cfg){
    $cfg = implode('/', explode('.', implode('', explode('.json', $cfg))));
    if(substr($cfg, 0, 1) == '/'){
        $cfg = substr($cfg,1);
    }

    if(file_exists(public_path('config/'.$cfg.'.json'))){
        $content = Storage::get('config/'.$cfg.'.json');

        return json_decode($content, true);
    } else {
        return null;
    }
}

/**
 * Clean Slashes
 * path\\/to\\/\/the//file -> path/to/the/file
 * @param $str
 * @return string
 */
function cleanSlash($str){
    $str = implode("/", explode("\\", $str));
    while( count(explode("//", $str)) > 1){
        $str = implode("/", explode("//", $str));
    }

    return $str;
}
