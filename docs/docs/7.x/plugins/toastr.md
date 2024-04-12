# Toastr

Toastr is a Javascript library for non-blocking notifications

> [https://codeseven.github.io/toastr](https://codeseven.github.io/toastr)

<img :src="$withBase('/assets/img/toastr.png')" alt="Toastr">

## Usage

Toastr is loaded by default, you don't have to call any loader.

```html
<button class="btn btn-primary" onclick="growl('Example')">growl</button>

<script>
    $('.btn').on('click', function () {    
        growl('Example', 'success')
    })
</script>
```

You have four styles available : info (default), success, danger, error