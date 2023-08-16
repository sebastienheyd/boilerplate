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
            'modal_route'  => route('boilerplate.dashboard.add-widget'),
            'load_widget'  => route('boilerplate.dashboard.load-widget'),
            'save_widgets' => route('boilerplate.dashboard.save-widgets'),
        ]);

        $widgets = [];

        foreach (auth()->user()->setting('dashboard', []) as $widget) {
            if ($widget === 'line-break') {
                $widgets[] = '<div class="d-line-break"></div>';
                continue;
            }

            $widget = app('boilerplate.dashboard.widgets')->getWidget($widget);

            if ($widget->permission !== null && ! Auth::user()->ability('admin', $widget->permission)) {
                continue;
            }

            $render = $widget->render();

            $widgets[] = view('boilerplate::dashboard.widget', [
                'widget'  => $widget,
                'content' => is_string($render) ? $render : $render->render()
            ])->render();
        }

        return view('boilerplate::dashboard', compact('JSparams', 'widgets'));
    }

    public function addWidget(Request $request)
    {
        $widgets = app('boilerplate.dashboard.widgets')->getWidgets();
        $installed = $request->post('widgets');

        return view('boilerplate::dashboard.widgets', compact('widgets', 'installed'));
    }

    public function loadWidget(Request $request)
    {
        $widget = app('boilerplate.dashboard.widgets')->getWidget($request->post('slug'));

        if ($widget->permission !== null && ! Auth::user()->ability('admin', $widget->permission)) {
            return '';
        }

        $render = $widget->render();

        return view('boilerplate::dashboard.widget', [
            'widget'  => $widget,
            'content' => is_string($render) ? $render : $render->render()
        ]);
    }

    public function saveWidgets(Request $request)
    {
        $widgets = json_decode($request->post('widgets'));
        auth()->user()->setting(['dashboard' => $widgets]);
    }
}
