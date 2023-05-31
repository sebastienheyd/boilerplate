<?php

return [
    'tooltip'   => 'Generar texto con GPT',
    'title'     => 'Generar con GPT',
    'error'     => 'Algo salió mal, por favor inténtelo de nuevo',
    'copy'      => 'Contenido copiado al portapapeles',
    'copyerror' => 'No se pudo copiar el contenido al portapapeles',
    'tabs'      => [
        'wizard'  => 'Asistente de generación',
        'prompt'  => 'Entrada manual',
        'rewrite' => 'Reescribir / Resumir',
    ],
    'form'      => [
        'copy'     => 'Copiar',
        'actas'    => 'Escribir como',
        'topic'    => 'Tema',
        'keywords' => 'Palabras clave',
        'prompt'   => 'Indicación',
        'pov'      => [
            'label'         => 'Punto de vista',
            'firstsingular' => 'Primera persona singular (yo, me, mi, mío)',
            'firstplural'   => 'Primera persona plural (nosotros, nos, nuestro, nuestros)',
            'second'        => 'Segunda persona (tú, tu, tuyo)',
            'third'         => 'Tercera persona (él, ella, ello, ellos)',
        ],
        'tone'     => [
            'label'         => 'Tono',
            'professionnal' => 'Profesional',
            'formal'        => 'Formal',
            'casual'        => 'Informal',
            'friendly'      => 'Amigable',
            'humorous'      => 'Humorístico',
        ],
        'language' => 'Idioma',
        'submit'   => 'Generar texto',
        'undo'     => 'Deshacer',
        'modify'   => 'Modificar',
        'confirm'  => 'Confirmar',
        'type'     => [
            'label'        => 'Tipo de texto',
            'tagline'      => 'Título / Lema',
            'introduction' => 'Introducción',
            'summary'      => 'Resumen',
            'article'      => 'Artículo',
        ],
        'rewrite'  => [
            'original' => 'Contenido original',
            'type'     => [
                'label'     => 'Tipo',
                'rewrite'   => 'Reescribir',
                'summary'   => 'Resumen',
                'title'     => 'Título',
                'translate' => 'Traducción',
            ]
        ]
    ],
];

