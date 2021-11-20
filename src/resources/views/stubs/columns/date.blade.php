Column::add(__('{{ $title }}'))
                ->data('{{ $field }}')
                ->dateFormat({{ $type === 'date' ? '__("boilerplate::date.Ymd")' : '' }}),
