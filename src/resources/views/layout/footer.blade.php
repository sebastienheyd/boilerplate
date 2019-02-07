<footer class="main-footer">
    <div class="pull-right hidden-xs">
        <a href="https://github.com/sebastienheyd/boilerplate">
            Boilerplate
        </a>
    </div>
    <strong>
        &copy; {{ date('Y') }}
        @if(config('boilerplate.app.vendorlink'))
            <a href="{{ config('boilerplate.app.vendorlink') }}">
                {!! config('boilerplate.app.vendorname') !!}
            </a>.
        @else
            {!! config('boilerplate.app.vendorname') !!}.
        @endif
    </strong>
    {{ __('boilerplate::layout.rightsres') }}
</footer>