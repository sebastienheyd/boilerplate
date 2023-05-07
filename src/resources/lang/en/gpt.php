<?php

return [
    'tooltip'      => 'Generate text with GPT',
    'title'        => 'Generate with GPT',
    'confirmtitle' => 'Generated text',
    'generation'   => 'Generation in progress, please wait...',
    'error'        => 'Something went wrong, please retry',
    'form'         => [
        'topic'    => 'Topic',
        'keywords' => 'Keywords',
        'pov'      => [
            'label'         => 'Point of view',
            'firstsingular' => 'First person singular (I, me, my, mine)',
            'firstplural'   => 'First person plurar (we, us, our, ours)',
            'second'        => 'Second person (you, your, yours)',
            'third'         => 'Third person (he, she, it, they)',
        ],
        'length'   => 'Maximum number of words',
        'tone'     => [
            'label'         => 'Tone',
            'professionnal' => 'Professional',
            'formal'        => 'Formal',
            'casual'        => 'Casual',
            'friendly'      => 'Friendly',
            'humorous'      => 'Humorous',
        ],
        'language' => 'Language',
        'submit'   => 'Generate text',
        'type'     => [
            'label'        => 'Type of text',
            'tagline'      => 'Tagline',
            'introduction' => 'Introduction',
            'summary'      => 'Summary',
            'article'      => 'Article',
        ],
    ],
];
