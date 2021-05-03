<?php

namespace Sebastienheyd\Boilerplate\View\Composers;

use Illuminate\View\View;

class FormComposer extends ComponentComposer
{
    public function compose(View $view)
    {
        parent::compose($view);

        $view->with('attributes', $this->attributes);
    }
}
