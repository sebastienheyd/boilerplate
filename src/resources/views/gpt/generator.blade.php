@component('boilerplate::form', ['route' => 'boilerplate.gpt.process'])
<input type="hidden" name="tab" value="generator">
<div class="row mt-2">
    <div class="col-12">
        @component('boilerplate::input', ['name' => 'topic', 'label' => 'boilerplate::gpt.form.topic', 'groupClass' => 'input-group-lg'])@endcomponent
    </div>
</div>
<div class="row">
    <div class="col-6">
        @component('boilerplate::input', ['name' => 'type', 'label' => 'boilerplate::gpt.form.type.label', 'type' => 'select', 'options' => [
            'a text' => '-',
            'a tagline' => __('boilerplate::gpt.form.type.tagline'),
            'an introduction' => __('boilerplate::gpt.form.type.introduction'),
            'a summary' => __('boilerplate::gpt.form.type.summary'),
            'a full article' => __('boilerplate::gpt.form.type.article'),
        ]])@endcomponent
    </div>
    <div class="col-6">
        @component('boilerplate::input', ['name' => 'actas', 'label' => 'boilerplate::gpt.form.actas'])@endcomponent
    </div>
</div>
<div class="row">
    <div class="col-6">
        @component('boilerplate::input', ['name' => 'pov', 'label' => 'boilerplate::gpt.form.pov.label', 'type' => 'select', 'options' => [
            '' => '-',
            'first person singular' => __('boilerplate::gpt.form.pov.firstsingular'),
            'first person plurar' => __('boilerplate::gpt.form.pov.firstplural'),
            'second person' => __('boilerplate::gpt.form.pov.second'),
            'third person' => __('boilerplate::gpt.form.pov.third'),
        ]])@endcomponent
    </div>
    <div class="col-6">
        @component('boilerplate::input', ['name' => 'tone', 'label' => 'boilerplate::gpt.form.tone.label', 'type' => 'select', 'options' => [
            '' => '-',
            'professionnal' => __('boilerplate::gpt.form.tone.professionnal'),
            'formal' => __('boilerplate::gpt.form.tone.formal'),
            'casual' => __('boilerplate::gpt.form.tone.casual'),
            'friendly' => __('boilerplate::gpt.form.tone.friendly'),
            'humorous' => __('boilerplate::gpt.form.tone.humorous'),
        ]])@endcomponent
    </div>
</div>
<div class="row">
    <div class="col-6">
        @component('boilerplate::input', ['type' => 'select', 'name' => 'language', 'label' => 'boilerplate::gpt.form.language', 'options' => collect(config('boilerplate.locale.languages'))->map(function($e){return $e['label'];})->toArray(), 'value' => App::getLocale()])@endcomponent
    </div>
</div>
@if(!empty($gpterror))
    <div class="alert alert-danger" id="gpterror">
        {{ $gpterror }}
    </div>
@endif
<div class="row">
    <div class="col-12 pt-2 text-center">
        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-gears mr-1"></i> @lang('boilerplate::gpt.form.submit')</button>
    </div>
</div>
@endcomponent