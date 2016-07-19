<?php

Route::filter('localization', function(){

});

Route::filter('translate', function() {

	if (env('APP_TRANSLATE', true)) {
		$translate = substr(Request::server('HTTP_ACCEPT_LANGUAGE'), 0, 2);

		$condition = array_search($translate, config('translate.available_trans'));

		if ($condition) {
			$locale = Request::cookie(config('translate.cookie_name'));
			$su_locale = Request::cookie(config('translate.su_cookie_name'));

			if(is_null($locale) && is_null($su_locale)){
				$exp = 450000;
				Cookie()->queue(cookie(config('translate.cookie_name'), $translate, $exp));
			}

			if(is_null($su_locale) && !is_null($locale)){
				App::setLocale($locale);
			} elseif (!is_null($su_locale) && is_null($locale)) {
				App::setLocale($su_locale);
			} else {
				App::setLocale($translate);
			}
		}
	}

});