<div class="row">
    <div class="col-lg-6">
    @component('boilerplate::input', ['type' => 'select', 'options' => \Sebastienheyd\Boilerplate\Dashboard\Widget::getColors(), 'name' => 'color', 'label' => 'Color', 'value' => $color ?? 'primary']) @endcomponent
    </div>
    <div class="col-lg-6">
        @component('boilerplate::input', ['type' => 'number', 'name' => 'length', 'label' => 'Length', 'value' => $length ?? 3, 'min' => 1, 'max' => 6]) @endcomponent
    </div>
</div>