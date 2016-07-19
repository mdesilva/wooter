<?php

include 'api_routes.php';

Route::get('auth/facebook', 'Auth\FacebookController@redirectToProvider');
Route::get('auth/facebook/callback', 'Auth\FacebookController@handleProviderCallback');

Route::group(['prefix' => '', 'before' => ['localization','translate']], function(){

	Route::get('', ['as' => 'home', 'uses'=>'PrimaryController@index']);
	Route::get('socket-test', ['uses'=>'SocketController@index']);
	Route::post('socket-test', ['uses'=>'SocketController@postMessage']);

    Route::group(['before' => ['ajax', 'user.is_guest'], 'namespace' => 'User'], function() {
        Route::get('verify-user/{token}', 'VerifyUser@verifyToken');
    });

	Route::group(['namespace' => 'Auth'], function() {
        Route::get('auth/integrate/facebook', 'FacebookController@redirectToProvider');

        Route::post('password/email', 'PasswordController@postEmail');
        Route::post('password/reset', 'PasswordController@postReset');

        Route::post('register', 'RegisterController@register');
    });

    Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function() {
        Route::get('user-management/login-as/{userId}', 'UserManagementController@loginAs');
        Route::get('user-management/login-as-facebook/{facebookUserId}', 'UserManagementController@loginAsFacebookUser');
    });

    Route::get('/media.src/{type}', [
        'middleware' => 'media.check',
        'as' => 'media',
        'uses' => 'API\AsseticController@show'
    ]);
    include 'static_routes.php';
});

Route::get('forbidden', function(){
    return response()->view('errors.403', [], 403);
});

if(detectEnvironment('local')){
    Route::get('/formly-generator', [
        'middleware' => 'formly',
        'uses' => 'API\FormlyController@index'
    ]);
    Route::get('/formly-generator/login', [
        'uses' => 'API\FormlyController@login'
    ]);
    Route::get('/fmly/{type}/{file}', [
        'uses' => 'API\FormlyController@show'
    ]);
    Route::post('/formly-generator/login', [
        'uses' => 'API\FormlyController@store'
    ]);
}
