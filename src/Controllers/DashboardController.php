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

            $widget->set($params)->make();

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
        $widget = $this->getWidgetOrFail($request->post('slug'));

        $widget->make();

        return view('boilerplate::dashboard.widget', [
            'widget' => $widget,
        ]);
    }

    public function editWidget(Request $request)
    {
        $widget = $this->getWidgetOrFail($request->post('slug'));

        $request->session()->forget('_old_input');

        $params = $this->getWidgetUserSettings($request->post('slug'));
        $params = array_merge($widget->getParameters(), $params);

        return view('boilerplate::dashboard.widgetEdit', [
            'widget' => $widget,
            'params' => $params,
        ]);
    }

    public function updateWidget(Request $request)
    {
        $widget = $this->getWidgetOrFail($request->post('widget-slug'));

        if (method_exists($widget, 'validator')) {
            $validator = $widget->validator($request);

            if ($validator->fails()) {
                $request->flash();
                $view = view($widget->getEditView())->withErrors($validator->errors());
                view()->share('errors', $view->errors);

                return response()->json(['success' => false, 'view' => $view->render()]);
            }
        }

        $input = $request->except('widget-slug', '_token');

        $settings = [];

        foreach ($widget->getParameters() as $k => $v) {
            if (! ($input[$k] ?? false) || $input[$k] === $v) {
                continue;
            }

            $settings[$k] = $input[$k];
        }

        $this->setWidgetUserSettings($request->post('widget-slug'), $settings);
        $widget->set($settings)->make();

        return response()->json([
            'success'  => true,
            'slug'     => $request->post('widget-slug'),
            'settings' => json_encode($settings),
            'widget'   => $widget->render()
        ]);
    }

    public function saveWidgets(Request $request)
    {
        $widgets = json_decode($request->post('widgets'));
        auth()->user()->setting(['dashboard' => $widgets]);
    }

    private function getWidgetOrFail($slug)
    {
        $widget = app('boilerplate.dashboard.widgets')->getWidget($slug);

        if (! $widget || ! $widget->isAuthorized()) {
            abort(404);
        }

        return $widget;
    }

    private function getWidgetUserSettings($slug)
    {
        foreach (auth()->user()->setting('dashboard', config('boilerplate.dashboard.widgets')) as $widgetParameters) {
            [$widgetSlug, $settings] = [array_key_first($widgetParameters), $widgetParameters[array_key_first($widgetParameters)]];
            if ($widgetSlug === $slug) {
                return $settings;
            }
        }

        return [];
    }

    private function setWidgetUserSettings($slug, $settings)
    {
        $widgets = auth()->user()->setting('dashboard', config('boilerplate.dashboard.widgets'));

        foreach ($widgets as $k => $widgetParameters) {
            if (array_key_first($widgetParameters) === $slug) {
                $widgets[$k] = [$slug => $settings];
                auth()->user()->setting(['dashboard' => $widgets]);
                return true;
            }
        }

        $widgets[] = [$slug => $settings];
        auth()->user()->setting(['dashboard' => $widgets]);

        return true;
    }
}
