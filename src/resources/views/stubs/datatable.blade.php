{!! '<?php' !!}

namespace App\Datatables;

@if($model !== '')
use {{ $model }};
@endif
use Sebastienheyd\Boilerplate\Datatables\Button;
use Sebastienheyd\Boilerplate\Datatables\Column;
use Sebastienheyd\Boilerplate\Datatables\Datatable;

class {{ $className }}Datatable extends Datatable
{
    public $slug = '{{ $slug }}';

    public function datasource()
    {
@if($model)
        return {{ $shortName }}::query();
@endif
    }

    public function setUp()
    {
@if($model)
        $this->order('id', 'desc');
@endif
    }

    public function columns(): array
    {
        return [
@foreach($columns as $column)
            {!! $column !!}
@endforeach
            Column::add()
                ->width('20px')
@if($model)
                ->actions(function ({{ $shortName }} ${{ strtolower($shortName) }}) {
                    return join([
                        // Button::show('{{ strtolower($shortName) }}.show', ${{ strtolower($shortName) }}),
                        // Button::edit('{{ strtolower($shortName) }}.edit', ${{ strtolower($shortName) }}),
                        // Button::delete('{{ strtolower($shortName) }}.destroy', ${{ strtolower($shortName) }}),
                    ]);
                }),
@else
                ->actions(function () {
                    return join([
                        Button::add()->icon('pencil-alt')->color('primary')->make(),
                    ]);
                }),
@endif
        ];
    }
}