<?php

return [
    'tooltip'   => 'Generate text with GPT',
    'title'     => 'Generate with GPT',
    'error'     => 'Something went wrong, please retry',
    'copy'      => 'Content copied to clipboard',
    'copyerror' => 'Content could not be copied to clipboard',
    'tabs'      => [
        'wizard'  => 'Generation Wizard',
        'prompt'  => 'Manual input',
        'rewrite' => 'Rewrite / Summarize',
    ],
    'form'      => [
        'copy'     => 'Copy',
        'actas'    => 'Write as',
        'topic'    => 'Topic',
        'keywords' => 'Keywords',
        'prompt'   => 'Prompt',
        'pov'      => [
            'label'         => 'Point of view',
            'firstsingular' => 'First person singular (I, me, my, mine)',
            'firstplural'   => 'First person plurar (we, us, our, ours)',
            'second'        => 'Second person (you, your, yours)',
            'third'         => 'Third person (he, she, it, they)',
        ],
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
        'undo'     => 'Undo',
        'modify'   => 'Modify',
        'confirm'  => 'Confirm',
        'type'     => [
            'label'        => 'Type of text',
            'tagline'      => 'Title / Tagline',
            'introduction' => 'Introduction',
            'summary'      => 'Summary',
            'article'      => 'Article',
        ],
        'rewrite'  => [
            'original' => 'Original content',
            'type'     => [
                'label'     => 'Type',
                'rewrite'   => 'Rewrite',
                'summary'   => 'Summary',
                'title'     => 'Title',
                'translate' => 'Translation',
            ]
        ]
    ],
];
