<?php

namespace Sebastienheyd\Boilerplate\Dashboard;

class UserWidget extends Widget
{
    protected $slug = 'users-number';
    protected $label = "Nombre d'utilisateurs";
    protected $description = "Affiche le nombre d'utilisateurs avec un accès rapide à la gestion des utilisateurs.";

    public function render()
    {
        return view('boilerplate::dashboard.usersNumber');
    }
}