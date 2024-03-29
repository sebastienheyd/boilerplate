<?php

namespace Sebastienheyd\Boilerplate\Dashboard\Widgets;

use Illuminate\Http\Request;
use Sebastienheyd\Boilerplate\Dashboard\Widget;
use Sebastienheyd\Boilerplate\Models\User;

class UsersNumber extends Widget
{
    protected $slug = 'users-number';
    protected $label = 'boilerplate::dashboard.users-number.label';
    protected $description = 'boilerplate::dashboard.users-number.description';
    protected $view = 'boilerplate::dashboard.widgets.usersNumber';
    protected $editView = 'boilerplate::dashboard.widgets.usersNumberEdit';
    protected $permission = 'users_crud';
    protected $size = 'xs';
    protected $parameters = [
        'color'    => 'primary',
    ];

    public function make()
    {
        $this->assign('num', User::count());
    }

    public function validator(Request $request)
    {
        return validator()->make($request->post(), [
            'color' => 'required',
        ]);
    }
}
