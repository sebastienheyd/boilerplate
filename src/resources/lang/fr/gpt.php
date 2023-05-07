<?php

return [
    'tooltip'      => 'Générer du texte avec GPT',
    'title'        => 'Générer avec GPT',
    'confirmtitle' => 'Texte généré',
    'generation'   => 'Génération en cours, veuillez patienter...',
    'error'        => 'Une erreur est survenue, veuillez réessayer',
    'form'         => [
        'topic'    => 'Sujet',
        'keywords' => 'Mots clés',
        'pov'      => [
            'label'         => 'Point de vue',
            'firstsingular' => 'Première personne singulière (je, me, mon, mien)',
            'firstplural'   => 'Première personne plurielle (nous, notre, nos)',
            'second'        => 'Deuxième personne (tu, toi, votre, vos)',
            'third'         => 'Troisième personne (il, elle, eux, elles)',
        ],
        'length'   => 'Nombre maximum de mots',
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
        'type'     => [
            'label'        => 'Type de texte',
            'tagline'      => 'Slogan',
            'introduction' => 'Introduction',
            'summary'      => 'Résumé',
            'article'      => 'Article',
        ],
    ],
];
