<?php

namespace Workbench\App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Workbench\Database\Seeders\DatabaseSeeder;

/**
 * Local demo environment only (composer serve, docker compose): loaded by testbench.yaml, never by
 * applications using the package.
 */
class WorkbenchServiceProvider extends ServiceProvider
{
    /**
     * Prefill the login form with the demo administrator credentials.
     *
     * @return void
     */
    public function boot(): void
    {
        View::composer('boilerplate::auth.login', function () {
            // Prefill the empty fields, rendered at the end of the page, after the form
            View::startPush('js', sprintf(
                '<script id="demo-prefill">Object.entries(%s).forEach(([name, value]) => {'
                .' const input = document.querySelector(`.login-box input[name="${name}"]`);'
                .' if (input && input.value === "") input.value = value; });</script>',
                json_encode(['email' => DatabaseSeeder::EMAIL, 'password' => DatabaseSeeder::PASSWORD])
            ));
        });
    }
}
