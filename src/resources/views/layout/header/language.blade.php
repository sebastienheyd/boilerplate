<li class="nav-item dropdown">
    {!! Form::open(['route' => 'boilerplate.lang.switch', 'method' => 'post', 'autocomplete'=> 'off']) !!}
        <x-boilerplate::select2 id="boilerplate-language" name="lang" :options="collect(config('boilerplate.locale.languages'))->map(function($e){return $e['label'];})->toArray()" :selected="App::getLocale()" data-route="{{ route('boilerplate.lang.switch', [], false) }}" group-class="mb-0" title="" onchange="this.form.submit()" />
    {!! Form::close() !!}
</li>