<?php

return [
    'tooltip'   => 'Générer du texte avec GPT',
    'title'     => 'Générer avec GPT',
    'error'     => 'Une erreur s\'est produite, veuillez réessayer',
    'copy'      => 'Contenu copié dans le presse-papier',
    'copyerror' => 'Impossible de copier le contenu dans le presse-papier',
    'tabs'      => [
        'wizard'  => 'Assistant de génération',
        'prompt'  => 'Saisie manuelle',
        'rewrite' => 'Réécrire / Résumer',
    ],
    'form'      => [
        'copy'     => 'Copier',
        'actas'    => 'Écrire en tant que',
        'topic'    => 'Sujet',
        'keywords' => 'Mots-clés',
        'prompt'   => 'Indication',
        'pov'      => [
            'label'         => 'Point de vue',
            'firstsingular' => 'Première personne du singulier (je, me, mon, le mien)',
            'firstplural'   => 'Première personne du pluriel (nous, nous, notre, les nôtres)',
            'second'        => 'Deuxième personne (tu, ton, le tien)',
            'third'         => 'Troisième personne (il, elle, cela, ils)',
        ],
        'tone'     => [
            'label'         => 'Tonalité',
            'professionnal' => 'Professionnel',
            'formal'        => 'Formel',
            'casual'        => 'Décontracté',
            'friendly'      => 'Amical',
            'humorous'      => 'Humoristique',
        ],
        'language' => 'Langue',
        'submit'   => 'Générer le texte',
        'undo'     => 'Annuler',
        'modify'   => 'Modifier',
        'confirm'  => 'Confirmer',
        'type'     => [
            'label'        => 'Type de texte',
            'tagline'      => 'Titre / Slogan',
            'introduction' => 'Introduction',
            'summary'      => 'Résumé',
            'article'      => 'Article',
        ],
        'rewrite'  => [
            'original' => 'Contenu original',
            'type'     => [
                'label'     => 'Type',
                'rewrite'   => 'Réécrire',
                'summary'   => 'Résumer',
                'title'     => 'Titrer',
                'translate' => 'Traduction',
            ]
        ]
    ],
];
