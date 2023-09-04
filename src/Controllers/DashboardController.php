<?php

namespace Sebastienheyd\Boilerplate\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Sebastienheyd\Boilerplate\Dashboard\DashboardWidgetsRepository;

class DashboardController
{
    private $registry;

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

            $widget = $this->getWidgetsRegistry()->getWidget($widgetSlug);

            if (! $widget || ! $widget->isAuthorized()) {
                continue;
            }

            $widget->set($params)->make();

            $widgets[] = view('boilerplate::dashboard.widget', [
                'widget'  => $widget,
                'content' => $widget->render(),
            ])->render();
        }

        return view('boilerplate::dashboard', compact('JSparams', 'widgets'));
    }

    /**
     * Show modal to add / remove a widget to the dashboard.
     *
     * @param  Request  $request
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function addWidget(Request $request)
    {
        $widgets = $this->getWidgetsRegistry()->getWidgets();
        $installed = $request->post('widgets');

        return view('boilerplate::dashboard.widgets', compact('widgets', 'installed'));
    }

    /**
     * Add a widget to the dashboard with a wrapper to allow editing.
     *
     * @param  Request  $request
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function loadWidget(Request $request)
    {
        $widget = $this->getWidgetOrFail($request->post('slug'));

        $widget->make();

        return view('boilerplate::dashboard.widget', [
            'widget' => $widget,
        ]);
    }

    /**
     * Show modal to edit widget settings.
     *
     * @param  Request  $request
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
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

    /**
     * Updates widget settings and saves them for the current user.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
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
            'widget'   => $widget->render(),
        ]);
    }

    /**
     * Saves all dashboard widgets, will be used when moved, deleted, etc...
     *
     * @param  Request  $request
     * @return void
     */
    public function saveWidgets(Request $request)
    {
        $widgets = json_decode($request->post('widgets')) ?? [];

        auth()->user()->setting(['dashboard' => $widgets]);
    }

    /**
     * Get widget from repository or show a 404 error page.
     *
     * @param  $slug
     * @return mixed
     */
    private function getWidgetOrFail($slug)
    {
        $widget = $this->getWidgetsRegistry()->getWidget($slug);

        if (! $widget || ! $widget->isAuthorized()) {
            abort(404);
        }

        return $widget;
    }

    /**
     * Load widgets from app path and return instance of registry.
     *
     * @return DashboardWidgetsRepository
     */
    private function getWidgetsRegistry()
    {
        if (! isset($this->registry)) {
            $this->registry = app('boilerplate.dashboard.widgets')->load(app_path('Dashboard'));
        }

        return $this->registry;
    }

    /**
     * Get widget settings for the current user.
     *
     * @param  $slug
     * @return array|mixed
     */
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

    /**
     * Set widget settings for the current user.
     *
     * @param  $slug
     * @param  $settings
     * @return true
     */
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
