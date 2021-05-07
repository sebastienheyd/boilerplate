<?php

namespace Sebastienheyd\Boilerplate\View\Composers;

use Illuminate\View\View;

class TinymceComposer extends ComponentComposer
{
    protected $props = [
        'id',
    ];

    public function compose(View $view)
    {
        parent::compose($view);

        $data = $view->getData();

        if (empty($data['id'])) {
            $view->with('id', uniqid('tinymce'));
        }

        // Check if sebastienheyd/boilerplate-media-manager is installed
        $providers = app()->getProviders('Sebastienheyd\BoilerplateMediaManager\ServiceProvider');
        $view->with('hasMediaManager', count($providers) === 1);
    }
}
