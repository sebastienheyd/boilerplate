<?php

$default = [
    'prefix' => config('boilerplate.app.prefix', ''),
    'namespace' => 'Sebastienheyd\Boilerplate\Controllers'
];

Route::group(array_merge($default, [ 'middleware' => [ 'web' ] ]), function() {

    // Login Routes...
    Route::get('login', [ 'as' => 'login', 'uses' => 'Auth\LoginController@showLoginForm' ]);
    Route::post('login', [ 'as' => 'login.post', 'uses' => 'Auth\LoginController@login' ]);
    Route::post('logout', [ 'as' => 'logout', 'uses' => 'Auth\LoginController@logout' ]);

    // Registration Routes...
    Route::get('register', [ 'as' => 'register', 'uses' => 'Auth\RegisterController@showRegistrationForm' ]);
    Route::post('register', [ 'as' => 'register.post', 'uses' => 'Auth\RegisterController@register' ]);

    // Password Reset Routes...
    Route::get('password/request', [ 'as' => 'password.request', 'uses' => 'Auth\ForgotPasswordController@showLinkRequestForm' ]);
    Route::post('password/email', [ 'as' => 'password.email', 'uses' => 'Auth\ForgotPasswordController@sendResetLinkEmail' ]);
    Route::get('password/reset/{token}', [ 'as' => 'password.reset', 'uses' => 'Auth\ResetPasswordController@showResetForm' ]);
    Route::post('password/reset', [ 'as' => 'password.reset.post', 'uses' => 'Auth\ResetPasswordController@reset' ]);

    Route::get('connect/{token?}', [ 'as' => 'users.firstlogin', 'uses' => 'Users\UsersController@firstLogin' ]);
    Route::post('connect/{token?}', [ 'uses' => 'Users\UsersController@firstLoginPost' ]);

});

Route::group(array_merge($default, [ 'middleware' => [ 'web', 'auth', 'ability:admin,backend_access' ] ]), function() {

    Route::get('/', [ 'as' => 'boilerplate.home', 'uses' => 'HomeController@index' ]);
    Route::resource('roles', 'Users\RolesController');
    Route::resource('users', 'Users\UsersController');
    Route::any('users/dt', [ 'as' => 'users.datatable', 'uses' => 'Users\UsersController@datatable' ]);
    Route::get('userprofile', [ 'as' => 'user.profile', 'uses' => 'Users\UsersController@profile' ]);
    Route::post('userprofile', [ 'uses' => 'Users\UsersController@profilePost' ]);
    Route::post('userprofile/avatardelete', [ 'as' => 'user.avatardelete', 'uses' => 'Users\UsersController@avatarDelete' ]);

    // Logs
    Route::group([ 'prefix' => 'logs', 'as' => 'logs.' ], function() {
        Route::get('/', [ 'as' => 'dashboard', 'uses' => 'Logs\LogViewerController@index' ]);
        Route::group([ 'prefix' => 'list' ], function() {

            Route::get('/', [ 'as' => 'list', 'uses' => 'Logs\LogViewerController@listLogs' ]);
            Route::delete('delete', [ 'as' => 'delete', 'uses' => 'Logs\LogViewerController@delete' ]);

            Route::group([ 'prefix' => '{date}' ], function() {
                Route::get('/', [ 'as' => 'show', 'uses' => 'Logs\LogViewerController@show' ]);
                Route::get('download', [ 'as' => 'download', 'uses' => 'Logs\LogViewerController@download' ]);
                Route::get('{level}', [ 'as' => 'filter', 'uses' => 'Logs\LogViewerController@showByLevel' ]);
            });
        });
    });
});