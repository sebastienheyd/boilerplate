<?php

return [
    'tooltip'      => 'Generar texto con GPT',
    'title'        => 'Generar con GPT',
    'confirmtitle' => 'Texto generado',
    'generation'   => 'Generación en curso, por favor espere...',
    'error'        => 'Algo salió mal, por favor inténtelo de nuevo',
    'form'         => [
        'topic'    => 'Tema',
        'keywords' => 'Palabras clave',
        'pov'      => [
            'label'         => 'Punto de vista',
            'firstsingular' => 'Primera persona singular (yo, mi, mío)',
            'firstplural'   => 'Primera persona plural (nosotros, nuestro, nuestros)',
            'second'        => 'Segunda persona (tú, usted, su, suyo)',
            'third'         => 'Tercera persona (él, ella, ello, ellos)',
        ],
        'length'   => 'Número máximo de palabras',
        'tone'     => [
            'label'         => 'Tono',
            'professionnal' => 'Profesional',
            'formal'        => 'Formal',
            'casual'        => 'Informal',
            'friendly'      => 'Amistoso',
            'humorous'      => 'Humorístico',
        ],
        'language' => 'Idioma',
        'submit'   => 'Generar texto',
        'type'     => [
            'label'        => 'Tipo de texto',
            'tagline'      => 'Lema',
            'introduction' => 'Introducción',
            'summary'      => 'Resumen',
            'article'      => 'Artículo',
        ],
    ],
];
