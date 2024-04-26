# Minify

This component will minify inline js or css

```html
<x-boilerplate::minify>
    <script>
        // ... script to minify
    </script>
</x-boilerplate::minify>
```

Or

```html
<x-boilerplate::minify type="css">
    <style>
        // ... style to minify
    </style>
</x-boilerplate::minify>
```

## Attributes

Attributes that can be used with this component :

| Option | Type | Default | Description |
| --- | --- | --- | --- |
| type | string | js | Specify the type to minify (js or css) |