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
        $this->order('id', 'desc');
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
                    return Button::add()
                        //->route('{{ strtolower($shortName) }}.edit', ${{ strtolower($shortName) }}->id)
                        ->icon('pencil-alt')
                        ->color('primary')
                        ->make();
                }),
@else
                ->actions(function () {
                    return Button::add()
                        ->icon('pencil-alt')
                        ->color('primary')
                        ->make();
                }),
@endif
        ];
    }
}