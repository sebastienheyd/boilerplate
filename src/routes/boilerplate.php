<?php

use Sebastienheyd\Boilerplate\Controllers\Auth\ForgotPasswordController;
use Sebastienheyd\Boilerplate\Controllers\Auth\LoginController;
use Sebastienheyd\Boilerplate\Controllers\Auth\RegisterController;
use Sebastienheyd\Boilerplate\Controllers\Auth\ResetPasswordController;
use Sebastienheyd\Boilerplate\Controllers\DashboardController;
use Sebastienheyd\Boilerplate\Controllers\DatatablesController;
use Sebastienheyd\Boilerplate\Controllers\DemoController;
use Sebastienheyd\Boilerplate\Controllers\GptController;
use Sebastienheyd\Boilerplate\Controllers\ImpersonateController;
use Sebastienheyd\Boilerplate\Controllers\LanguageController;
use Sebastienheyd\Boilerplate\Controllers\Logs\LogViewerController;
use Sebastienheyd\Boilerplate\Controllers\Select2Controller;
use Sebastienheyd\Boilerplate\Controllers\Users\RolesController;
use Sebastienheyd\Boilerplate\Controllers\Users\UsersController;

Route::group([
    'prefix'     => config('boilerplate.app.prefix', ''),
    'domain'     => config('boilerplate.app.domain', ''),
    'middleware' => ['web', 'boilerplate.locale'],
    'as'         => 'boilerplate.',
], function () {
    // Logout
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    // Language switch
    if (config('boilerplate.locale.switch', false)) {
        Route::post('language', [LanguageController::class, 'switch'])->name('lang.switch');
    }

    // Frontend
    Route::group(['middleware' => ['boilerplate.guest']], function () {
        // Login
        Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
        Route::post('login', [LoginController::class, 'login'])->name('login.post');

        // Registration
        Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
        Route::post('register', [RegisterController::class, 'register'])->name('register.post');

        // Password reset
        Route::prefix('password')->as('password.')->group(function () {
            Route::get('request', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('request');
            Route::post('email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('email');
            Route::get('reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('reset');
            Route::post('reset', [ResetPasswordController::class, 'reset'])->name('reset.post');
        });

        // First login
        Route::get('connect/{token?}', [UsersController::class, 'firstLogin'])->name('users.firstlogin');
        Route::post('connect/{token?}', [UsersController::class, 'firstLoginPost'])->name('users.firstlogin.post');
    });

    // Email verification
    Route::prefix('email')->middleware('boilerplate.auth')->as('verification.')->group(function () {
        Route::get('verify', [RegisterController::class, 'emailVerify'])->name('notice');
        Route::get('verify/{id}/{hash}', [RegisterController::class, 'emailVerifyRequest'])->name('verify');
        Route::post('verification-notification', [RegisterController::class, 'emailSendVerification'])->name('send');
    });

    // Backend
    Route::group(['middleware' => ['boilerplate.auth', 'ability:admin,backend_access', 'boilerplate.emailverified']], function () {
        // Impersonate another user
        if (config('boilerplate.app.allowImpersonate', false)) {
            Route::as('impersonate.')->group(function () {
                Route::get('unauthorized', [ImpersonateController::class, 'unauthorized'])->name('unauthorized');
                Route::prefix('impersonate')->group(function () {
                    Route::post('/', [ImpersonateController::class, 'impersonate'])->name('user');
                    Route::get('stop', [ImpersonateController::class, 'stopImpersonate'])->name('stop');
                    Route::post('select', [ImpersonateController::class, 'selectImpersonate'])->name('select');
                });
            });
        }

        // Dashboard
        Route::get('/', [config('boilerplate.menu.dashboard', DashboardController::class), 'index'])->name('dashboard');
        if (config('boilerplate.dashboard.edition', false)) {
            Route::prefix('dashboard/widget')->as('dashboard.')->group(function () {
                Route::post('add', [DashboardController::class, 'addWidget'])->name('add-widget');
                Route::post('load', [DashboardController::class, 'loadWidget'])->name('load-widget');
                Route::post('edit', [DashboardController::class, 'editWidget'])->name('edit-widget');
                Route::post('update', [DashboardController::class, 'updateWidget'])->name('update-widget');
                Route::post('save', [DashboardController::class, 'saveWidgets'])->name('save-widgets');
            });
        }

        // Components demo page
        Route::get('/demo', [DemoController::class, 'index'])->name('demo');

        // Session keep-alive
        if (config('boilerplate.app.keepalive', false)) {
            Route::post('keep-alive', [UsersController::class, 'sessionKeepAlive'])->name('session.keepalive');
        }

        // Datatables
        Route::post('datatables/{slug}', [DatatablesController::class, 'make'])->name('datatables');
        Broadcast::channel('dt.{name}.{signature}', function ($user, $name, $signature) {
            return channel_hash_equals($signature, 'dt', $name);
        });

        // Select2
        Route::post('select2', [Select2Controller::class, 'make'])->name('select2');

        // Roles and users
        Route::resource('roles', RolesController::class)->except('show')->middleware(['ability:admin,roles_crud']);
        Route::resource('users', UsersController::class)->middleware('ability:admin,users_crud')->except('show');

        // Profile
        Route::prefix('userprofile')->as('user.')->group(function () {
            Route::get('/', [UsersController::class, 'profile'])->name('profile');
            Route::post('/', [UsersController::class, 'profilePost'])->name('profile.post');
            Route::post('settings', [UsersController::class, 'storeSetting'])->name('settings');
            Route::get('avatar/url', [UsersController::class, 'getAvatarUrl'])->name('avatar.url');
            Route::post('avatar/upload', [UsersController::class, 'avatarUpload'])->name('avatar.upload');
            Route::post('avatar/gravatar', [UsersController::class, 'getAvatarFromGravatar'])->name('avatar.gravatar');
            Route::post('avatar/delete', [UsersController::class, 'avatarDelete'])->name('avatar.delete');
        });

        // ChatGPT
        if (config('boilerplate.app.openai.key')) {
            Route::prefix('gpt')->as('gpt.')->group(function () {
                Route::get('/', [GptController::class, 'index'])->name('index');
                Route::post('/', [GptController::class, 'process'])->name('process');
                Route::get('/stream', [GptController::class, 'stream'])->name('stream');
            });
        }

        // Logs
        if (config('boilerplate.app.logs', false)) {
            Route::prefix('logs')->as('logs.')->middleware('ability:admin,logs')->group(function () {
                Route::get('/', [LogViewerController::class, 'index'])->name('list');
                Route::delete('delete', [LogViewerController::class, 'delete'])->name('delete');
                Route::prefix('{date}')->group(function () {
                    Route::get('/', [LogViewerController::class, 'show'])->name('show');
                    Route::get('download', [LogViewerController::class, 'download'])->name('download');
                });
            });
        }
    });
});
