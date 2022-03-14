<?php

return [
    'vendor'    => 'Log viewer by <a href="https://github.com/ARCANEDEV/LogViewer">Arcanedev</a>',
    'menu'      => [
        'category'  => 'Logs',
        'stats'     => 'Statistics',
        'reports'   => 'Reports',
    ],
    'stats' => [
        'entries'   => ':count entries - :percent %',
    ],
    'list' => [
        'title'             => 'Logs list',
        'actions'           => 'Actions',
        'deletequestion'    => 'Are you sure you want to delete this log file ?',
        'empty-logs'        => 'The list of logs is empty',
    ],
    'show' => [
        'title'         => ':date report',
        'file'          => ':date log',
        'backtolist'    => 'List of logs',
        'download'      => 'Download',
        'delete'        => 'Delete log file',
        'levels'        => 'Levels',
        'loginfo'       => 'Log info',
        'filepath'      => 'File path',
        'logentries'    => 'Log entries',
        'size'          => 'Size',
        'createdat'     => 'Created at',
        'updatedat'     => 'Updated at',
        'page'          => 'Page :current of :last',
        'env'           => 'Env',
        'level'         => 'Level',
        'time'          => 'Time',
        'header'        => 'Header',
    ],
];
