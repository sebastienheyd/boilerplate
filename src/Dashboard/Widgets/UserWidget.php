<?php

namespace Sebastienheyd\Boilerplate\Dashboard\Widgets;

use Sebastienheyd\Boilerplate\Dashboard\Widget;

class UserWidget extends Widget
{
    protected $slug = 'users-number';
    protected $label = "Nombre d'utilisateurs";
    protected $description = "Affiche le nombre d'utilisateurs avec un accès rapide à la gestion des utilisateurs.";
    protected $width = ['sm' => 6, 'md' => 6, 'xl' => 4, 'xxl' => 3];

    public function render()
    {
        return view('boilerplate::dashboard.usersNumber', ['num' => rand(0,123)]);
    }
}