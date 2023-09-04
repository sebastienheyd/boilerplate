<?php

namespace Sebastienheyd\Boilerplate\Tests\Datatables;

use Illuminate\Database\Eloquent\Builder;
use Sebastienheyd\Boilerplate\Datatables\Button;
use Sebastienheyd\Boilerplate\Datatables\Column;
use Sebastienheyd\Boilerplate\Datatables\Datatable;
use Sebastienheyd\Boilerplate\Tests\Models\User;

class TestDatatable extends Datatable
{
    public $slug = 'test1';

    public function setUp()
    {
        $this->locale([
            'deleteConfirm' => 'Delete the test?',
        ])
            ->permissions('users_crud')
            ->condensed()
            ->buttons('filters', 'csv', 'print')
            ->order('created_at', 'desc')
            ->lengthMenu([[10, 25, 50, 100, -1], [10, 25, 50, 100, '∞']])
            ->pageLength(50)
            ->setRowId(function ($item) {
                return 'id-'.$item['id'];
            })
            ->setRowClass(function ($item) {
                return $item['id'] % 2 == 0 ? 'even' : 'odd';
            })
            ->setRowAttr([
                'data-id' => function ($item) {
                    return 'row-'.$item['id'];
                },
            ])
            ->setRowData([
                'color' => 'red',
            ])
            ->pagingType('numbers')
            ->setOffset(0)
            ->setTotalRecords(3)
            ->setFilteredRecords(3)
            ->filter(function ($q) {
                $q->whereNotNull('id');
            })
            ->showCheckboxes()
            ->noPaging()
            ->noLengthChange()
            ->noOrdering()
            ->noSorting()
            ->noSearching()
            ->noInfo()
            ->skipPaging()
            ->stateSave();
    }

    public function datasource()
    {
        return User::with('roles')->select('users.*');
    }

    public function columns(): array
    {
        return [
            Column::add('Id')
                ->name('id')
                ->width('100')
                ->tooltip('test')
                ->hidden()
                ->notSortable()
                ->order(function ($query, $direction) {
                    return $query->orderBy('last_name', $direction);
                })
                ->data('id'),

            Column::add('Created At 1')
                ->data('created_at')
                ->dateFormat(),

            Column::add('Created At 1')
                ->data('created_at')
                ->fromNow(),

            Column::add('Created At 3')
                ->data('created_at')
                ->dateFormat('d/m/Y'),

            Column::add(__('boilerplate::users.list.roles'))
                ->notOrderable()
                ->filter(function ($query, $q) {
                    $query->whereHas('roles', function (Builder $query) use ($q) {
                        $query->where('name', '=', $q);
                    });
                })
                ->data('roles', function ($user) {
                    return $user->roles->implode('display_name', ', ') ?: '-';
                })
                ->filterOptions(function () {
                    $roleModel = config('boilerplate.laratrust.role');

                    return $roleModel::all()->pluck('display_name', 'name')->toArray();
                }),

            Column::add('fake')
                ->filterOptions([
                    'val1',
                    'val2',
                ]),

            Column::add()
                ->actions(function ($user) {
                    return join([
                        Button::show('boilerplate.users.edit', $user->id),
                        Button::edit('boilerplate.users.edit', $user->id),
                        Button::delete('boilerplate.users.destroy', $user->id),
                        Button::add('test-button')
                            ->attributes(['test' => true])
                            ->icon('cubes', 'x')
                            ->class('test-button')
                            ->link('http://localhost/'.$user->id)
                            ->color('primary')
                            ->icon('pencil-alt')
                            ->make(),
                    ]);
                }),
        ];
    }
}
