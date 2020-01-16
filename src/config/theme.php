<?php

$theme = include __DIR__.'/themes/default.php';

// Additionnal views to append items to the navbar
$theme['navbar'] += [
    'left'  => [],
    'right' => [],
];

return $theme;
