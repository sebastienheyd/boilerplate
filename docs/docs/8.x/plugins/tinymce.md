# TinyMCE

TinyMCE is the an advanced WYSIWYG HTML editor designed to simplify website content creation.

> [https://www.tiny.cloud](https://www.tiny.cloud)

<img :src="$withBase('/assets/img/tinymce.png')" alt="TinyMCE">

## Component

A Laravel Blade Component is available for TinyMCE, see the [component documentation](../components/tinymce)

## Usage

To use TinyMCE you can use the loading view [`boilerplate::load.tinymce`](https://github.com/sebastienheyd/boilerplate/blob/e1dc4b29920f011271a1a7ad682c3e82643180d9/src/resources/views/load/tinymce.blade.php)

You can find an example of use here : [tinymce.blade.php](https://github.com/sebastienheyd/boilerplate/blob/e1dc4b29920f011271a1a7ad682c3e82643180d9/src/resources/views/plugins/demo/tinymce.blade.php)

```html
@section('content')
    <textarea id="tiny">
        <h1>TinyMCE demo</h1>
    </textarea>
@endsection

@include('boilerplate::load.tinymce')

@push('js')
    <script>
        $('#tiny').tinymce({});
    </script>
@endpush
```