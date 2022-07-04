<li class="nav-item">
    @if(session()->has('impersonate'))
        <div class="d-flex align-items-center h-100">
            <a href="{{ route('boilerplate.impersonate.stop', [], false) }}" class="nav-link px-1" data-toggle="tooltip" title="@lang('boilerplate::layout.stop_impersonate')">
                <span>{{ Auth::user()->name }}</span>
                <span class="fa fa-undo fa-xs pl-1"></span>
            </a>
        </div>
    @else
    <x-boilerplate::select2 id="impersonate-user" name="impersonate-user" :ajax="route('boilerplate.impersonate.select', [], false)" :placeholder="__('boilerplate::layout.view_as')" group-class="mb-0" data-route="{{ route('boilerplate.impersonate.user', [], false) }}"></x-boilerplate::select2>
    @endif
</li>