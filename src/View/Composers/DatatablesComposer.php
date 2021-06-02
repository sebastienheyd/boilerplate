<?php

namespace Sebastienheyd\Boilerplate\View\Composers;

use Illuminate\Support\Facades\App;
use Illuminate\View\View;

class DatatablesComposer
{
    /**
     * Called when view load/datatables.blade.php is called.
     * This is defined in BoilerPlateServiceProvider.
     *
     * @param View $view
     */
    public function compose(View $view)
    {
        $languages = [
            'en' => 'English',
            'es' => 'Spanish',
            'fa' => 'Persian',
            'fr' => 'French',
            'it' => 'Italian',
            'tr' => 'Turkish',
        ];

        $locale = App::getLocale();

        $view->with('locale', isset($languages[$locale]) ? $languages[$locale] : 'English');

        $plugins = [
            'select',
            'autoFill',
            'buttons',
            'colReorder',
            'fixedHeader',
            'keyTable',
            'responsive',
            'rowGroup',
            'rowReorder',
            'scroller',
            'searchBuilder',
            'searchPanes',
        ];

        $view->with('plugins', $plugins);
    }
}
