<?php

namespace Sebastienheyd\Boilerplate\Controllers\Auth;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController
{
    use SendsPasswordResetEmails;

    /**
     * Get password request form view.
     *
     * @return Application|Factory|View
     */
    public function showLinkRequestForm()
    {
        return view('boilerplate::auth.passwords.email');
    }
}
