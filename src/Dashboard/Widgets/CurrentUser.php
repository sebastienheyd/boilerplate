<?php

namespace Sebastienheyd\Boilerplate\Dashboard\Widgets;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Sebastienheyd\Boilerplate\Dashboard\Widget;

class CurrentUser extends Widget
{
    protected $slug = 'current-user';
    protected $label = 'boilerplate::dashboard.current-user.label';
    protected $description = 'boilerplate::dashboard.current-user.description';
    protected $view = 'boilerplate::dashboard.widgets.current-user';
    protected $editView = 'boilerplate::dashboard.widgets.current-userEdit';
    protected $width = ['sm' => 12, 'md' => 6, 'xl' => 5, 'xxl' => 3];

    protected $parameters = [
        'color'    => 'info',
    ];

    public function make()
    {
        $this->assign('user', Auth::user());
    }

    public function validator(Request $request)
    {
        return validator()->make($request->post(), [
            'color' => 'required',
        ]);
    }
}
