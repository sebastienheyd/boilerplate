Column::add(__('{{ $title }}'))
                ->width('180px')
                ->data('{{ $field }}')
                ->dateFormat({!! $type === 'date' ? '__("boilerplate::date.Ymd")' : '' !!}),
