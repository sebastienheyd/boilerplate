<div class="card card-widget widget-user">
    <div class="widget-user-header bg-{{ $color }}">
        <h3 class="widget-user-username">{{ $user->first_name }} {{ $user->last_name }}</h3>
        <h5 class="widget-user-desc small">{{ $user->getRolesList() }}</h5>
    </div>
    <div class="widget-user-image">
        <img class="img-circle elevation-2" src="{{ $user->avatar_url }}" alt="User Avatar">
    </div>
    <div class="card-footer">
        <div class="row">
            <div class="col-6 border-right">
                <div class="description-block">
                    <a href="{{ route('boilerplate.user.profile') }}" class="btn btn-outline-secondary">@lang('boilerplate::users.profile.title')</a>
                </div>
            </div>
            <div class="col-6">
                <div class="description-block">
                    @component('boilerplate::form', ['route' => 'boilerplate.logout'])
                        <button type="submit" class="btn btn-outline-secondary logout" data-question="{{ __('boilerplate::layout.logoutconfirm') }}" data-toggle="tooltip" title="@lang('boilerplate::layout.logout')">
                            @lang('boilerplate::layout.logout')
                        </button>
                    @endcomponent
                </div>
            </div>
        </div>
    </div>
</div>