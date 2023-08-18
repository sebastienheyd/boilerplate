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
            'modal_route'   => route('boilerplate.dashboard.add-widget'),
            'load_widget'   => route('boilerplate.dashboard.load-widget'),
            'save_widgets'  => route('boilerplate.dashboard.save-widgets'),
            'edit_widget'   => route('boilerplate.dashboard.edit-widget'),
            'update_widget' => route('boilerplate.dashboard.update-widget'),
        ]);

        $widgets = [];

        foreach (auth()->user()->setting('dashboard', config('boilerplate.dashboard.widgets')) as $widget) {
            [$widgetSlug, $params] = [array_key_first($widget), $widget[array_key_first($widget)]];

            if ($widgetSlug === 'line-break') {
                $widgets[] = '<div class="d-line-break"></div>';
                continue;
            }

            $widget = app('boilerplate.dashboard.widgets')->getWidget($widgetSlug);

            if (! $widget || ! $widget->isAuthorized()) {
                continue;
            }

            $widget->setParameter($params)->make();

            $widgets[] = view('boilerplate::dashboard.widget', [
                'widget'  => $widget,
                'content' => $widget->render()
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

        if (! $widget || ! $widget->isAuthorized()) {
            abort(404);
        }

        return view('boilerplate::dashboard.widget', [
            'widget'  => $widget,
        ]);
    }

    public function editWidget(Request $request)
    {
        $widget = app('boilerplate.dashboard.widgets')->getWidget($request->post('slug'));

        if (! $widget || ! $widget->isAuthorized()) {
            abort(404);
        }

        foreach (auth()->user()->setting('dashboard', config('boilerplate.dashboard.widgets')) as $widgetParameters) {
            [$widgetSlug, $params] = [array_key_first($widgetParameters), $widgetParameters[array_key_first($widgetParameters)]];

            if ($widgetSlug !== $request->post('slug')) {
                continue;
            }

            $params = array_merge($widget->getParameters(), $params);
        }

        return view('boilerplate::dashboard.widgetEdit', [
            'widget'  => $widget,
            'params' => $params,
        ]);
    }

    public function updateWidget(Request $request)
    {
        $widget = app('boilerplate.dashboard.widgets')->getWidget($request->post('widget-slug'));

        $params = $request->except('widget-slug', '_token');

        $settings = [];

        foreach ($widget->getParameters() as $k => $v) {
            if (! ($params[$k] ?? false) || $params[$k] === $v) {
                continue;
            }

            $settings[$k] = $params[$k];
        }
        dd($settings);
    }

    public function saveWidgets(Request $request)
    {
        $widgets = json_decode($request->post('widgets'));
        auth()->user()->setting(['dashboard' => $widgets]);
    }
}
