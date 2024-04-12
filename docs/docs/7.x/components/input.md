# Input

```html
<x-boilerplate::input name="example" label="Example" />
```

Will render

<img :src="$withBase('/assets/img/input.png')" alt="Input">

## Attributes

Attributes that can be used with this component :

| Option            | Type    | Default      | Description                                                                          |
|-------------------|---------|--------------|--------------------------------------------------------------------------------------|
| name              | string  | null         | Input name (required)                                                                |
| type              | string  | text         | Type of input, can be text, email, password, file, number, date, textarea and select |
| label             | string  | null         | Input label, can be a translation string                                             |
| help              | string  | null         | Help message that will be displayed under the input field                            |
| value             | mixed   | null         | Value of input                                                                       |
| clearable         | boolean | false        | For text input only, adds a clear button to reset the input value                    |
| options           | array   | []           | For select, array of options                                                         |
| prepend-text      | string  | Empty string | Text that will be added on the left side of the input, see "Append / Prepend" below  | 
| append-text       | string  | Empty string | Text that will be added on the right side of the input, see "Append / Prepend" below | 
| group-class       | string  | null         | Additionnal class that will be added to form-group                                   | 
| group-id          | string  | null         | ID that will be added to form-group                                                  | 
| input-group-class | string  | null         | Additionnal class that will be added to input-group                                  | 

All of the attributes that are not in the list above will be added as attributes to the input field :

```html
<x-boilerplate::input name="example" data-toggle="tooltip" data-title="Tooltip content" />
```

**NB** : for non primitive values that not using a simple string you have to use the `:` character as a prefix :

```html
<x-boilerplate::input type="date" name="date" :value="\Carbon\Carbon::now()" :placeholder="__('stringToTranslate')"/>
<x-boilerplate::input type="select" name="select" :options="[1 => 'Option 1', 2 => 'Option 2']" />
```

## Append / Prepend

Instead of a simple text, you can use directly a FontAwesome class string, which will be converted into an icon :

```html
<x-boilerplate::input name="test" prepend-text="fas fa-cubes"/>
```

<img :src="$withBase('/assets/img/input-prepend-text.png')" alt="Append">

Or you can use a slot to set more complex add-on :

```html
<x-boilerplate::input name="test">
    <x-slot name="prepend">
        <button class="btn btn-secondary">Button</button>
    </x-slot>
</x-boilerplate::input>
```

<img :src="$withBase('/assets/img/input-prepend.png')" alt="Prepend">

## Laravel 6

Laravel 6 does not support Blade x components, but you can use the `@component` directive instead :

```html
@component('boilerplate::input', ['name' => 'example', 'label' => 'Example']) @endcomponent
```

With slot :

```html
@component('boilerplate::input', ['name' => 'example', 'label' => 'Example'])
    @slot('prepend')
        <button class="btn btn-secondary">Button</button>
    @endslot
@endcomponent
```