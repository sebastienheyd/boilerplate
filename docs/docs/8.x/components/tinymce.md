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
| toolbar     | string  | null    | Custom toolbar configuration                              | 
| contextmenu | string  | null    | Custom context menu configuration                         | 

For all non primitive values that not using a simple string you have to use the `:` character as a prefix :

```html
<x-boilerplate::tinymce id="example" name="example" :value="$content" />
```

## Toolbar customization

You can customize the toolbar by using the `toolbar` attribute:

```html
<x-boilerplate::tinymce 
    name="content" 
    toolbar="undo redo | bold italic | link image" 
/>
```

### Available toolbar items

- **Basic actions**: `undo`, `redo`, `cut`, `copy`, `paste`
- **Text formatting**: `bold`, `italic`, `underline`, `strikethrough`, `subscript`, `superscript`
- **Alignment**: `alignleft`, `aligncenter`, `alignright`, `alignjustify`, `customalignleft`, `customalignright`
- **Lists**: `bullist`, `numlist`, `outdent`, `indent`
- **Styles**: `styleselect`, `formatselect`, `fontselect`, `fontsizeselect`
- **Colors**: `forecolor`, `backcolor`
- **Links and media**: `link`, `unlink`, `image`, `media`, `table`
- **Others**: `hr`, `removeformat`, `searchreplace`, `code`, `fullscreen`, `help`

Use `|` to separate toolbar groups.

## Context menu customization

You can customize the context menu (right-click menu) by using the `contextmenu` attribute:

```html
<x-boilerplate::tinymce 
    name="content" 
    contextmenu="bold italic underline | link image table" 
/>
```

### Available context menu items

- **Text formatting**: `bold`, `italic`, `underline`, `strikethrough`
- **Clipboard**: `cut`, `copy`, `paste`
- **Links and media**: `link`, `image`, `imagetools`, `table`
- **Others**: `spellchecker`

## Complete example

```html
<x-boilerplate::tinymce 
    name="content"
    label="Content"
    toolbar="undo redo | styleselect | bold italic underline | alignleft aligncenter alignright | bullist numlist | link image table | code fullscreen"
    contextmenu="link image table spellchecker bold italic underline"
    :sticky="true"
    min-height="300"
    help="Enter your content here"
/>
```