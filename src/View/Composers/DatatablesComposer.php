<?php

namespace Sebastienheyd\Boilerplate\View\Composers;

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
            'en'    => 'English',
            'fr'    => 'French',
            'es'    => 'Spanish',
            'tr'    => 'Turkish',
        ];

        $locale = config('boilerplate.app.locale');

        $view->with('locale', isset($languages[$locale]) ? $languages[$locale] : 'English');
    }
}
