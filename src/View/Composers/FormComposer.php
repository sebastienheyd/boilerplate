<?php

namespace Sebastienheyd\Boilerplate\View\Composers;

use Illuminate\View\View;

class FormComposer extends ComponentComposer
{
    protected $props = [
        'route',
        'method',
        'files',
    ];

    public function compose(View $view)
    {
        parent::compose($view);

        $data = $view->getData();

        $route = '';
        if (is_array($data['route'] ?? '')) {
            $route = route($data['route'][0], array_slice($data['route'], 1), false);
        } elseif (! empty($data['route'])) {
            $route = route($data['route'], [], false);
        }

        $view->with('route', $route);
        $view->with('method', strtoupper($data['method'] ?? 'post'));
        $view->with('files', ! empty($data['files']));
    }
}
