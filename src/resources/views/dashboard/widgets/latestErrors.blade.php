@component('boilerplate::card', ['title' => 'boilerplate::dashboard.latest-errors.label', 'color' => $color])
    @slot('tools')
        <a href="{{ route('boilerplate.logs.list') }}" type="button" class="btn btn-secondary btn-xs">View all logs</a>
    @endslot
    <table class="table table-condensed table-striped table-borderless table-hover" id="latest-errors">
    @forelse($errors as $error)
        <tr>
            <td>
                <div class="d-flex justify-content-between mb-2">
                    <div>
                        <span class="badge badge-danger mr-2">{{ __('Error') }}</span>
                        <span class="badge badge-secondary">{{ $error['date'] }}</span>
                    </div>
                    <small><i class="fa-solid fa-angle-down"></i></small>
                </div>
                <div class="small">{{ trim($error['message']) }}</div>
                <ul class="list-unstyled latest-logs-stack mt-2 d-none">
                    @foreach($error['stack'] as $err)
                        <li class="py-1">
                            <div class="text-bold pb-1">{{ $err['function'] }}</div>
                            <div class="d-flex justify-content-between">
                                <div>{{ $err['path'] }}</div>
                                <div>{{ $err['line'] }}</div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </td>
        </tr>
    @empty
        <tr>
            <td>
                @lang('boilerplate::dashboard.latest-errors.no-error')
            </td>
        </tr>
    @endforelse
    </table>
@endcomponent
@component('boilerplate::minify', ['type' => 'css'])
<style>
    #latest-errors tr {
        cursor: pointer;
    }

    .latest-logs-stack {
        background: #222;
        color: #FFF;
        padding: 1rem;
        font-family: "Lucida Console", monospace, sans-serif;
        font-size: .6rem;
    }

    .latest-logs-stack li {
        border-bottom: 1px solid rgba(255,255,255,.2);
    }
</style>
@endcomponent
@component('boilerplate::minify')
<script>
    $(document).on('click', '#latest-errors tr', function(e) {
        $(this).find('.latest-logs-stack').toggleClass('d-none');
        $(this).find('.fa-angle-down, .fa-angle-up').toggleClass('fa-angle-down fa-angle-up');
    })
</script>
@endcomponent