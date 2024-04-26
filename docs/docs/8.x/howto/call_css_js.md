# Call your own css or js

Boilerplate layout comes with two [Blade stacks](https://laravel.com/docs/blade#stacks): `js` and `css`.

You can push your assets to these stacks in your blade views:

```html
@push('js')
    <script src="/example.js"></script>
    <script>
        alert('hello')
    </script>
@endpush
```

```html
@push('css')
    <link href="/style.css" rel="stylesheet" type="text/css">
    <style>
        body { background: red }
    </style>
@endpush
```