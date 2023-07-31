<?php

namespace Sebastienheyd\Boilerplate\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class DashboardController
{
    /**
     * Show the application dashboard.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('boilerplate::dashboard');
    }

    public function addWidget()
    {
        $widgets = app('boilerplate.dashboard.widgets')->getWidgets();

        return view('boilerplate::dashboard.widgets', compact('widgets'));
    }
}
