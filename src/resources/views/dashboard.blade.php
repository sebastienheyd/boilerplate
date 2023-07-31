@extends('boilerplate::layout.index', ['title' => __('boilerplate::layout.dashboard')])

@section('content')
<section>
    <button type="button" class="btn btn-primary" id="add-a-widget">Add a widget</button>
</section>
@endsection

@push('js')
@component('boilerplate::minify')
<script>
    $('#add-a-widget').on('click', function() {
        $.ajax({
            url: '{{ route('boilerplate.dashboard.add-widget') }}',
            type: 'get',
            success: function(html){
                console.log(html)
            }
        });
    })
</script>
@endcomponent
@endpush