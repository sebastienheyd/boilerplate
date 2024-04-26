# FileInput

An enhanced HTML 5 file input with file preview for various files, offers multiple selection, and more. 

> [https://plugins.krajee.com/file-input](https://plugins.krajee.com/file-input)

<img :src="$withBase('/assets/img/fileinput.png')" alt="FileInput" style="max-width:700px">

## Loading
 
 To use Bootstrap-fileinput on your page you can use the loading view [`boilerplate::load.fileinput`](https://github.com/sebastienheyd/boilerplate/blob/e1dc4b29920f011271a1a7ad682c3e82643180d9/src/resources/views/load/fileinput.blade.php)
 
 ```html
 @include('boilerplate::load.fileinput')
 ```

## Usage

See examples on [https://plugins.krajee.com/file-input/demo](https://plugins.krajee.com/file-input/demo)

```html
@section('content')
    <div class="file-loading"> 
        <input id="files" name="files[]" type="file" multiple>
    </div>
@endsection

@include('boilerplate::load.fileinput')

@push('js') 
<script>
    $(document).ready(function() {
        $("#files").fileinput({
            showUpload: false,
            dropZoneEnabled: false,
            maxFileCount: 10,
        });
    });
</script>
@endpush
```