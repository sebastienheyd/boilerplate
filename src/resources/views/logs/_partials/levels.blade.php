<table class="table table-sm table-striped no-border">
    <tbody>
    @foreach($log->menu() as $level => $item)
        @if($item['count'] === 0)
            @continue
        @endif
        <tr>
            <td>
                <a href="{{ $item['count'] === 0 ? '#' : $item['url'] }}" class="{{ $item['count'] === 0 ? 'no-log ' : '' }}d-flex justify-content-between">
                    <span class="badge badge-pill level-{{ $level }}">
                        {!! $item['icon'] !!} {{ $item['name'] }}
                    </span>
                    <span class="badge badge-pill level-{{ $level }}">
                        {{ $item['count'] }}
                    </span>
                </a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
