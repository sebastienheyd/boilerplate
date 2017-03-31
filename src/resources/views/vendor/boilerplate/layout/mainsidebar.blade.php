<aside class="main-sidebar">
    <section class="sidebar" style="height: auto;">
        <ul class="sidebar-menu">
            <li class="header text-uppercase">{{ __('boilerplate::layout.mainmenu') }}</li>
            <li class="active">
                <a href="#">
                    <i class="fa fa-home"></i> <span>{{ __('boilerplate::layout.dashboard') }}</span>
                </a>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-wrench"></i> <span>{{ __('boilerplate::layout.administration') }}</span>
                    <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="#"><i class="fa fa-circle-o"></i> {{ __('boilerplate::layout.role_managament') }}</a></li>
                    <li><a href="#"><i class="fa fa-circle-o"></i> {{ __('boilerplate::layout.user_managament') }}</a></li>
                </ul>
            </li>
        </ul>
    </section>
</aside>