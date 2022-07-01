<li class="nav-item dropdown">
    <x-boilerplate::select2 id="boilerplate-language" name="boilerplate-language" :options="collect(config('boilerplate.locale.languages'))->map(function($e){return $e['label'];})->toArray()" :selected="App::getLocale()" data-route="{{ route('boilerplate.lang.switch', [], false) }}" group-class="mb-0" title=""/>
</li>