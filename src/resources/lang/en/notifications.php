<?php

return [
    'hello'      => 'Hello,',
    'greeting'   => 'Hello :firstname,',
    'salutation' => 'Regards,<br>:name',
    'subcopy'    => 'If you’re having trouble clicking the ":actionText" button, copy and paste the URL below into your web browser: [:actionUrl](:actionUrl)',
    'copyright'  => '&copy; :date :name. All rights reserved.',
    'newuser'    => [
        'subject' => 'Your account has been created on :name',
        'intro'   => 'You are receiving this email because an account has been created for you by :name.',
        'button'  => 'Sign in',
        'outro'   => 'On your first login you will be invited to set your password',
    ],
    'resetpassword' => [
        'subject' => 'Password reset request',
        'intro'   => 'You are receiving this email because we received a password reset request for your account.',
        'button'  => 'Reset password',
        'outro'   => 'If you did not request a password reset, no further action is required.',
    ],
];
