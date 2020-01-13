<div class="card no-shadow">
    <div class="card-header bg-gray font-weight-bold py-1">
        {{ __('boilerplate::logs.show.levels') }}
    </div>
    <ul class="list-group list-unstyled">
        @foreach($log->menu() as $level => $item)
            @if ($item['count'] === 0)
                <li>
                    <a href="#" class="list-group-item py-2 d-flex justify-content-between" style="opacity:.5;background: #F0F0F0; border-radius:0">
                        <span class="badge badge-pill text-secondary">
                        {!! $item['icon'] !!} {{ $item['name'] }}
                        </span>
                        <span class="badge badge-pill badge-secondary">
                            {{ $item['count'] }}
                        </span>
                    </a>
                </li>
            @else
                <li>
                <a href="{{ $item['url'] }}" class="list-group-item py-2 {{ $level }}  d-flex justify-content-between" style="border-radius: 0">
                    <span class="badge badge-pill level-{{ $level }}">
                        {!! $item['icon'] !!} {{ $item['name'] }}
                    </span>
                    <span class="badge badge-pill level-{{ $level }}">
                        {{ $item['count'] }}
                    </span>
                </a>
                </li>
            @endif
        @endforeach
    </ul>
</div>
