<aside class="main-sidebar">
    <section class="sidebar" style="height: auto;">
        <ul class="sidebar-menu">
            <li class="header text-uppercase">{{ __('boilerplate::layout.mainmenu') }}</li>
            <li class="{{ active_class(if_uri(config('boilerplate.app.prefix', '').'/')) }}">
                <a href="{{ config('boilerplate.app.prefix', '').'/' }}">
                    <i class="fa fa-cog"></i> <span>Plugins</span>
                </a>
            </li>

            @ability('admin','users_crud,roles_crud')
            <li class="treeview {{ active_class(if_route_pattern(['roles.*', 'users.*'])) }}">
                <a href="#">
                    <i class="fa fa-lock"></i> <span>{{ __('boilerplate::layout.access') }}</span>
                    <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                </a>
                <ul class="treeview-menu">

                    @ability('admin','roles_crud')
                    <li class="{{ active_class(if_route_pattern('roles.*')) }}">
                        <a href="{{ route('roles.index') }}">
                            <i class="fa fa-circle-o"></i> {{ __('boilerplate::layout.role_management') }}
                        </a>
                    </li>
                    @endability

                    @ability('admin','users_crud')
                    <li>
                        <a href="#">
                            <i class="fa fa-circle-o"></i> {{ __('boilerplate::layout.user_management') }}
                        </a>
                    </li>
                    @endability
                </ul>
            </li>
            @endability
        </ul>
    </section>
</aside>