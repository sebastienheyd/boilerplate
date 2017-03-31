<?php

$namespace = 'Sebastienheyd\Boilerplate\Controllers\\';

Route::group(['prefix' => config('boilerplate.app.prefix', ''), 'middleware' => ['web']], function() use ($namespace) {

    Route::get('/', ['as' => 'home', 'uses' => $namespace.'HomeController@index']);

    // Login Routes...
    Route::get('login', ['as' => 'login', 'uses' => $namespace.'LoginController@showLoginForm']);
    Route::post('login', ['as' => 'login.post', 'uses' => $namespace.'LoginController@login']);
    Route::post('logout', ['as' => 'logout', 'uses' => $namespace.'LoginController@logout']);

    // Registration Routes...
    Route::get('register', ['as' => 'register', 'uses' => $namespace.'RegisterController@showRegistrationForm']);
    Route::post('register', ['as' => 'register.post', 'uses' => $namespace.'RegisterController@register']);

    // Password Reset Routes...
    Route::get('password/request', ['as' => 'password.request', 'uses' => $namespace.'ForgotPasswordController@showLinkRequestForm']);
    Route::post('password/email', ['as' => 'password.email', 'uses' => $namespace.'ForgotPasswordController@sendResetLinkEmail']);
    Route::get('password/reset/{token}', ['as' => 'password.reset', 'uses' => $namespace.'ResetPasswordController@showResetForm']);
    Route::post('password/reset', ['as' => 'password.reset.post', 'uses' => $namespace.'ResetPasswordController@reset']);

});