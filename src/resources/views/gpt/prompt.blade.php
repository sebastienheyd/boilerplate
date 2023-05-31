@component('boilerplate::form', ['route' => 'boilerplate.gpt.process'])
<input type="hidden" name="tab" value="prompt">
<div class="row mt-2">
    <div class="col-12">
        @component('boilerplate::input', ['name' => 'prompt', 'type' => 'textarea', 'rows' => '10'])@endcomponent
    </div>
</div>
<div class="row">
    <div class="col-12 pt-2 text-center">
        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-gears mr-1"></i> @lang('boilerplate::gpt.form.submit')</button>
    </div>
</div>
@endcomponent