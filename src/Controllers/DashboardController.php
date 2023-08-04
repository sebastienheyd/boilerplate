<?php

namespace Sebastienheyd\Boilerplate\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class DashboardController
{
    /**
     * Show the application dashboard.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $JSparams = json_encode([
            'modal_route' => route('boilerplate.dashboard.add-widget'),
            'load_widget' => route('boilerplate.dashboard.load-widget'),
        ]);

        $widgets = [];

        return view('boilerplate::dashboard', compact('JSparams', 'widgets'));
    }

    public function addWidget()
    {
        $widgets = app('boilerplate.dashboard.widgets')->getWidgets();

        return view('boilerplate::dashboard.widgets', compact('widgets'));
    }

    public function loadWidget(Request $request)
    {
        $widget = app('boilerplate.dashboard.widgets')->getWidget($request->post('slug'));
        $render = $widget->render();

        return view('boilerplate::dashboard.widget', [
            'width' => $widget->width,
            'content' => is_string($render) ? $render : $render->render()
        ]);
    }
}
