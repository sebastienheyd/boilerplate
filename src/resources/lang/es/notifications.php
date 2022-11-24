<?php

return [
    'hello'      => 'Hola,',
    'greeting'   => 'Hola :firstname,',
    'salutation' => 'Atentamente,<br>:name',
    'subcopy'    => 'Si tienes alguna dificultad para hacer clic en el boton ":actionText", copia y pega la dirección que aparece a continuación en tu navegador: [:actionUrl](:actionUrl)',
    'copyright'  => '&copy; :date :name. Todos los derechos reservados.',
    'newuser'    => [
        'subject' => 'Tu cuenta ha sido creada :name',
        'intro'   => 'Está recibiendo este correo electrónico porque se ha creado una cuenta para usted con :name.',
        'button'  => 'Entrar',
        'outro'   => 'La primera vez que accedas al panel, será necesario que introduzas una nueva contraseña.',
    ],
    'resetpassword' => [
        'subject' => 'Petición de reinicio de contraseña',
        'intro'   => 'Has recibido este correo electrónico porque alguien ha solicitado la recuperación de contraseña en tu cuenta.',
        'button'  => 'Reiniciar contraseña',
        'outro'   => 'Si no has solicitado la recuperación de contraseña, no es necesario que hagas nada.',
    ],
];
