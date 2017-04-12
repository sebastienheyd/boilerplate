<?php

$ns = 'Sebastienheyd\Boilerplate\Controllers\\';

Route::group(['prefix' => config('boilerplate.app.prefix', ''), 'middleware' => ['web']], function() use ($ns) {

    // Login Routes...
    Route::get('login', ['as' => 'login', 'uses' => $ns.'Auth\LoginController@showLoginForm']);
    Route::post('login', ['as' => 'login.post', 'uses' => $ns.'Auth\LoginController@login']);
    Route::post('logout', ['as' => 'logout', 'uses' => $ns.'Auth\LoginController@logout']);

    // Registration Routes...
    Route::get('register', ['as' => 'register', 'uses' => $ns.'Auth\RegisterController@showRegistrationForm']);
    Route::post('register', ['as' => 'register.post', 'uses' => $ns.'Auth\RegisterController@register']);

    // Password Reset Routes...
    Route::get('password/request', ['as' => 'password.request', 'uses' => $ns.'Auth\ForgotPasswordController@showLinkRequestForm']);
    Route::post('password/email', ['as' => 'password.email', 'uses' => $ns.'Auth\ForgotPasswordController@sendResetLinkEmail']);
    Route::get('password/reset/{token}', ['as' => 'password.reset', 'uses' => $ns.'Auth\ResetPasswordController@showResetForm']);
    Route::post('password/reset', ['as' => 'password.reset.post', 'uses' => $ns.'Auth\ResetPasswordController@reset']);

    Route::get('connect/{token?}', ['as' => 'users.firstlogin', 'uses' => $ns.'Users\UsersController@firstLogin']);
    Route::post('connect/{token?}', ['uses' => $ns.'Users\UsersController@firstLoginPost']);

});

Route::group(['prefix' => config('boilerplate.app.prefix', ''), 'middleware' => ['web', 'auth', 'ability:admin,backend_access']], function() use ($ns) {

    Route::get('/', ['as' => 'boilerplate.home', 'uses' => $ns.'HomeController@index']);
    Route::resource('/roles', $ns.'Users\RolesController');
    Route::resource('/users', $ns.'Users\UsersController');
    Route::any('/users/dt', ['as' => 'users.datatable', 'uses' => $ns.'Users\UsersController@datatable']);

});