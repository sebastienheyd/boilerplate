<li class="nav-item dropdown">
    @component('boilerplate::form', ['route' => 'boilerplate.lang.switch'])
        @component('boilerplate::select2', ['name' => 'lang', 'id' => 'boilerplate-language', 'options' => collect(config('boilerplate.locale.languages'))->map(function($e){return $e['label'];})->toArray(), 'selected' => App::getLocale(), 'data-route' => route('boilerplate.lang.switch', [], false), 'groupClass' => 'mb-0', 'onchange' => 'this.form.submit()'])@endcomponent
    @endcomponent
</li>