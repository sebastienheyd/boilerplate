<?php

return [
    'fields' => [
        'last_name'         => 'Nom',
        'first_name'        => 'Prénom',
        'email'             => 'E-mail',
        'password'          => 'Mot de passe',
        'password_confirm'  => 'Confirmation du mot de passe',
    ],
    'password' => [
        'title'             => 'Mot de passe oublié',
        'intro'             => 'Saisissez le champ suivant réinitialiser votre mot de passe',
        'submit'            => 'Envoyer le lien de réinitialisation',
        'login_link'        => "S'identifier avec un utilisateur existant",
    ],
    'password_reset' => [
        'title'             => 'Réinitialisation du mot de passe',
        'intro'             => 'Saisissez les champs suivants pour réinitialiser votre mot de passe',
        'submit'            => 'Réinitialiser',
    ],
    'register' => [
        'title'             => 'Créer un nouveau compte utilisateur',
        'intro'             => 'Saisissez les champs suivants pour créer un nouvel utilisateur',
        'register_button'   => 'Enregistrer',
        'login_link'        => "S'identifier avec un utilisateur existant",
    ],
    'login' => [
        'title'             => 'Identification',
        'intro'             => 'Identifiez vous pour démarrer une session',
        'rememberme'        => 'Se souvenir de moi',
        'signin'            => 'Connexion',
        'forgotpassword'    => "J'ai oublié mon mot de passe",
        'register'          => 'Créer un nouveau compte',
    ],
    'firstlogin' => [
        'title'             => 'Première connexion',
        'intro'             => 'Ceci est votre première connexion, merci de saisir un mot de passe pour activer votre compte.',
        'button'            => 'Connexion',
    ],
    'impersonate' => [
        'back_to_impersonator' => 'Accéder à la page en tant que :user',
        'not_authorized'       => ':user n\'est pas autorisé(e) à accéder à la page :page.',
        'back_to_dashboard'    => 'Retourner au tableau de bord',
    ],
];
