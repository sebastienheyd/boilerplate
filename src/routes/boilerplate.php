<?php

$default = [
    'prefix'     => config('boilerplate.app.prefix', ''),
    'domain'     => config('boilerplate.app.domain', ''),
    'middleware' => ['web', 'boilerplatelocale'],
    'as'         => 'boilerplate.',
];

Route::group($default, function () {
    // Dashboard
    Route::group(['middleware' => ['boilerplateauth', 'ability:admin,backend_access']], function () {
        Route::get('/', ['as' => 'dashboard', 'uses' => config('boilerplate.menu.dashboard').'@index']);
    });

    Route::group(['namespace' => '\Sebastienheyd\Boilerplate\Controllers'], function () {
        Route::post('keep-alive', ['as' => 'keepalive', 'uses' => 'Users\UsersController@keepAlive']);

        // Login
        Route::get('login', ['as' => 'login', 'uses' => 'Auth\LoginController@showLoginForm']);
        Route::post('login', ['as' => 'login.post', 'uses' => 'Auth\LoginController@login']);
        Route::post('logout', ['as' => 'logout', 'uses' => 'Auth\LoginController@logout']);

        // Registration
        Route::get('register', ['as' => 'register', 'uses' => 'Auth\RegisterController@showRegistrationForm']);
        Route::post('register', ['as' => 'register.post', 'uses' => 'Auth\RegisterController@register']);

        // Password reset
        Route::get('password/request', [
            'as'   => 'password.request',
            'uses' => 'Auth\ForgotPasswordController@showLinkRequestForm',
        ]);
        Route::post('password/email', [
            'as'   => 'password.email',
            'uses' => 'Auth\ForgotPasswordController@sendResetLinkEmail',
        ]);
        Route::get('password/reset/{token}', [
            'as'   => 'password.reset',
            'uses' => 'Auth\ResetPasswordController@showResetForm',
        ]);
        Route::post('password/reset', ['as' => 'password.reset.post', 'uses' => 'Auth\ResetPasswordController@reset']);

        // First login
        Route::get('connect/{token?}', [
            'as'   => 'users.firstlogin',
            'uses' => 'Users\UsersController@firstLogin',
        ]);
        Route::post('connect/{token?}', [
            'as'   => 'users.firstlogin.post',
            'uses' => 'Users\UsersController@firstLoginPost',
        ]);

        // Backend
        Route::group(['middleware' => ['boilerplateauth', 'ability:admin,backend_access']], function () {
            // Roles and users
            Route::resource('roles', 'Users\RolesController', ['except' => 'show']);
            Route::resource('users', 'Users\UsersController', ['except' => 'show']);
            Route::any('users/dt', ['as' => 'users.datatable', 'uses' => 'Users\UsersController@datatable']);
            Route::get('userprofile', ['as' => 'user.profile', 'uses' => 'Users\UsersController@profile']);
            Route::post('userprofile', ['as' => 'user.profile.post', 'uses' => 'Users\UsersController@profilePost']);

            // Avatar
            Route::get(
                'userprofile/avatar/url',
                ['as' => 'user.avatar.url', 'uses' => 'Users\UsersController@getAvatarUrl']
            );
            Route::post(
                'userprofile/avatar/upload',
                ['as' => 'user.avatar.upload', 'uses' => 'Users\UsersController@avatarUpload']
            );
            Route::post(
                'userprofile/avatar/gravatar',
                ['as' => 'user.avatar.gravatar', 'uses' => 'Users\UsersController@getAvatarFromGravatar']
            );
            Route::post(
                'userprofile/avatar/delete',
                ['as' => 'user.avatar.delete', 'uses' => 'Users\UsersController@avatarDelete']
            );

            // Logs
            Route::group(['prefix' => 'logs', 'as' => 'logs.'], function () {
                Route::get('/', ['as' => 'dashboard', 'uses' => 'Logs\LogViewerController@index']);
                Route::group(['prefix' => 'list'], function () {
                    Route::get('/', ['as' => 'list', 'uses' => 'Logs\LogViewerController@listLogs']);
                    Route::delete('delete', ['as' => 'delete', 'uses' => 'Logs\LogViewerController@delete']);

                    Route::group(['prefix' => '{date}'], function () {
                        Route::get('/', ['as' => 'show', 'uses' => 'Logs\LogViewerController@show']);
                        Route::get('download', ['as' => 'download', 'uses' => 'Logs\LogViewerController@download']);
                        Route::get('{level}', ['as' => 'filter', 'uses' => 'Logs\LogViewerController@showByLevel']);
                    });
                });
            });
        });
    });
});
