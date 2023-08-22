@component('boilerplate::card', ['title' => 'Latest errors', 'color' => $color])
    <table class="table table-condensed table-striped table-borderless">
    @forelse($errors as $error)
        <tr>
            <td>
                <div class="d-flex justify-content-start mb-2">
                    <div class="badge badge-danger mr-2">{{ __('Error') }}</div>
                    <div class="badge badge-secondary">{{ $error['date'] }}</div>
                </div>
                <div class="small">{{ $error['message'] }}</div>
            </td>
        </tr>
    @empty
        Your application does not generate any error
    @endforelse
    </table>
@endcomponent