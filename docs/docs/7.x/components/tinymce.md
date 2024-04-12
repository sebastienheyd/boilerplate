# TinyMCE

```html
<x-boilerplate::tinymce name="html" />
```

Will render

<img :src="$withBase('/assets/img/tinymce.png')" alt="TinyMCE">

> If you have installed the package [sebastien/boilerplate-media-manager](https://github.com/sebastienheyd/boilerplate-media-manager), the media manager will be automatically added to TinyMCE for images and documents.
 
::: tip Add GPT feature
See [Generate text with GPT](../howto/generate_text_gpt.md) documentation if you want to add the feature to TinyMCE.
:::

## Value

The value can be set by using slot or the value attribute

```html
<x-boilerplate::tinymce name="example">
    <h2>TinyMCE demo</h2><p>Lorem ipsum dolor sit amet.</p>
</x-boilerplate::tinymce>
```

or

```html
<x-boilerplate::tinymce name="example" value="<h2>TinyMCE demo</h2><p>Lorem ipsum dolor sit amet.</p>" />
```

## Attributes

Attributes that can be used with this component :

| Option      | Type    | Default | Description                                               |
|-------------|---------|---------|-----------------------------------------------------------|
| name        | string  | null    | Input name (required)                                     |
| label       | string  | name    | Input label, can be a translation string                  |
| help        | string  | null    | Help message that will be displayed under the input field |
| sticky      | boolean | false   | True if toolbar must stick to the top of the page         |
| value       | mixed   | null    | Value of input                                            | 
| group-class | string  | null    | Additionnal class that will be added to form-group        | 
| group-id    | string  | null    | ID that will be added to form-group                       | 
| min-height  | integer | null    | Minimum editor height                                     | 
| max-height  | integer | null    | Maximum editor height                                     | 

For all non primitive values that not using a simple string you have to use the `:` character as a prefix :

```html
<x-boilerplate::tinymce id="example" name="example" :value="$content" />
```

## Laravel 6

Laravel 6 does not support Blade x components, but you can use the `@component` directive instead :

```html
@component('boilerplate::tinymce') @endcomponent
```