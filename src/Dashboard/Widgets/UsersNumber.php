<?php

namespace Sebastienheyd\Boilerplate\Dashboard\Widgets;

use Sebastienheyd\Boilerplate\Dashboard\Widget;
use Sebastienheyd\Boilerplate\Models\User;

class UsersNumber extends Widget
{
    protected $slug = 'users-number';
    protected $label = "Nombre d'utilisateurs";
    protected $description = "Affiche le nombre d'utilisateurs avec un accès rapide à la gestion des utilisateurs.";
    protected $size = 'xs';
    protected $view = 'boilerplate::dashboard.widgets.usersNumber';
    protected $editView = 'boilerplate::dashboard.widgets.usersNumberEdit';
    protected $parameters = [
        'color'    => 'primary',
        'showLink' => true,
    ];

    public function make()
    {
        $this->assign('num', User::count());
    }
}