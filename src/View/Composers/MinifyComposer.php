<?php

namespace Sebastienheyd\Boilerplate\View\Composers;

use Illuminate\View\View;
use MatthiasMullie\Minify;

class MinifyComposer extends ComponentComposer
{
    protected $props = [
        'type' => 'js'
    ];

    public function compose(View $view)
    {
        parent::compose($view);

        if (! config('boilerplate.theme.minify', false)) {
            return;
        }

        if ($this->props['type'] === 'js') {
            $minifier = new Minify\JS($view->slot);
        } else {
            $minifier = new Minify\CSS($view->slot);
        }

        $view->slot = $minifier->minify();
    }
}
