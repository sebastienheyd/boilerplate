<table class="table table-striped no-border table-sm">
    <tr>
        <th class="text-nowrap">{{ __('boilerplate::logs.show.filepath') }}</th>
        <td>{{ $log->getPath() }}</td>
    </tr>
    <tr>
        <th class="text-nowrap">{{ __('boilerplate::logs.show.logentries') }}</th>
        <td>{{ $entries->total() }}</td>
    </tr>
    <tr>
        <th class="text-nowrap">{{ __('boilerplate::logs.show.size') }}</th>
        <td>{{ $log->size() }}</td>
    </tr>
    <tr>
        <th class="text-nowrap">{{ __('boilerplate::logs.show.createdat') }}</th>
        <td>{{ $log->createdAt()->isoFormat(__('boilerplate::date.YmdHis')) }}</td>
    </tr>
    <tr>
        <th class="text-nowrap">{{ __('boilerplate::logs.show.updatedat') }}</th>
        <td>{{ $log->updatedAt()->isoFormat(__('boilerplate::date.YmdHis')) }}</td>
    </tr>
</table>