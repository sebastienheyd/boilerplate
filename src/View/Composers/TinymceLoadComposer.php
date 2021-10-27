<?php

namespace Sebastienheyd\Boilerplate\View\Composers;

use Illuminate\View\View;

class TinymceLoadComposer extends ComponentComposer
{
    public function compose(View $view)
    {
        parent::compose($view);

        // Check if sebastienheyd/boilerplate-media-manager is installed
        $providers = app()->getProviders('Sebastienheyd\BoilerplateMediaManager\ServiceProvider');
        $view->with('hasMediaManager', ! empty($providers));
    }
}
