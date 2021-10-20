<?php

namespace Sebastienheyd\Boilerplate\View\Composers;

use Illuminate\View\View;
use MatthiasMullie\Minify;

class MinifyComposer extends ComponentComposer
{
    public function compose(View $view)
    {
        parent::compose($view);

        if (! config('boilerplate.theme.minify', false)) {
            return;
        }

        $isJs = ($this->attributes['type'] ?? 'js') === 'js';
        $view->slot = ($isJs ? new Minify\JS($view->slot) : new Minify\CSS($view->slot))->minify();
    }
}
