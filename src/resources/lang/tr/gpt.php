<?php

return [
    'tooltip'      => 'GPT ile metin oluşturun',
    'title'        => 'GPT ile oluşturun',
    'confirmtitle' => 'Oluşturulan metin',
    'generation'   => 'Oluşturma işlemi devam ediyor, lütfen bekleyin...',
    'error'        => 'Bir şeyler yanlış gitti, lütfen tekrar deneyin',
    'form'         => [
        'topic'    => 'Konu',
        'keywords' => 'Anahtar kelimeler',
        'pov'      => [
            'label'         => 'Görüş noktası',
            'firstsingular' => 'Tekil birinci kişi (Ben)',
            'firstplural'   => 'Çoğul birinci kişi (Biz)',
            'second'        => 'İkinci kişi (Sen/Siz)',
            'third'         => 'Üçüncü kişi (O/Onlar)',
        ],
        'length'   => 'Maksimum kelime sayısı',
        'tone'     => [
            'label'         => 'Ton',
            'professionnal' => 'Profesyonel',
            'formal'        => 'Resmi',
            'casual'        => 'Sıradan',
            'friendly'      => 'Dostane',
            'humorous'      => 'Komik',
        ],
        'language' => 'Dil',
        'submit'   => 'Metin oluştur',
        'type'     => [
            'label'        => 'Metin türü',
            'tagline'      => 'Slogan',
            'introduction' => 'Giriş',
            'summary'      => 'Özet',
            'article'      => 'Makale',
        ],
    ],
];
