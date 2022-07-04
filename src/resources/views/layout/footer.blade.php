<footer class="main-footer text-sm">
    <div class="d-flex justify-content-between flex-wrap">
        <div>
            <strong>
                &copy; {{ date('Y') }}
                @if(config('boilerplate.theme.footer.vendorlink'))
                    <a href="{{ config('boilerplate.theme.footer.vendorlink') }}">
                        {!! config('boilerplate.theme.footer.vendorname') !!}
                    </a>.
                @else
                    {!! config('boilerplate.theme.footer.vendorname') !!}.
                @endif
            </strong>
            {{ __('boilerplate::layout.rightsres') }}
        </div>
        <a href="https://github.com/sebastienheyd/boilerplate">
            Boilerplate | {{ \Composer\InstalledVersions::getPrettyVersion('sebastienheyd/boilerplate') }}
        </a>
    </div>
</footer>