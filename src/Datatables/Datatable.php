<?php

namespace Sebastienheyd\Boilerplate\Datatables;

use Closure;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\DataTables;

abstract class Datatable
{
    public $slug = '';
    protected object $datasource;
    protected bool $checkboxes = false;
    protected string $checkboxesField = 'id';
    protected ?Closure $filter = null;
    protected int $filteredRecords = 0;
    protected ?int $offset = null;
    protected array $rowAttr = [];
    protected string|Closure $rowClass = '';
    protected array $rowData = [];
    protected string|Closure $rowId = '';
    protected bool $skipPaging = false;
    protected int $totalRecords = 0;
    protected array $locale = [];
    protected array $permissions = ['backend_access'];
    protected array $orderAttr = [];
    protected array $attributes = [
        'filters'        => true,
        'info'           => true,
        'lengthChange'   => true,
        'order'          => [],
        'ordering'       => true,
        'pageLength'     => 10,
        'paging'         => true,
        'pagingType'     => 'simple_numbers',
        'searching'      => true,
        'stateSave'      => false,
        'condensed'      => false,
        'lengthMenu'     => [[10, 25, 50, 100, -1], [10, 25, 50, 100, '∞']],
        'buttons'        => ['filters'],
        'footerCallback' => null,
    ];

    /**
     * Renders the DataTable Json that will be used by the ajax call.
     *
     * @return JsonResponse
     *
     * @throws Exception
     */
    public function make(): JsonResponse
    {
        $this->setUp();

        if (! Auth::user()->ability(['admin'], $this->permissions)) {
            abort(503);
        }

        if ($this->datasource() instanceof DataTableAbstract) {
            $datatable = $this->datasource();
        } else {
            $datatable = DataTables::of($this->datasource());
        }

        if ($this->filter) {
            $datatable->filter($this->filter);
        }

        if ($this->offset) {
            $datatable->setOffset($this->offset);
        }

        if ($this->totalRecords) {
            $datatable->setTotalRecords($this->totalRecords);
        }

        if ($this->filteredRecords) {
            $datatable->setFilteredRecords($this->filteredRecords);
        }

        if ($this->skipPaging) {
            $datatable->skipPaging();
        }

        $raw = [];

        foreach (['rowAttr', 'rowClass', 'rowData', 'rowId'] as $attr) {
            if ($this->{$attr}) {
                $datatable->{'set'.ucfirst($attr)}($this->{$attr});
            }
        }

        foreach ($this->getColumns() as $column) {
            if (empty($column->data)) {
                continue;
            }

            if ($column->filter) {
                $datatable->filterColumn($column->name ?? $column->data, $column->filter);
            }

            if ($column->order) {
                $datatable->orderColumn($column->name ?? $column->data, $column->order);
            }

            if ($column->raw) {
                $raw[] = $column->data;
                $datatable->editColumn($column->data, $column->raw);
            }
        }

        if (! empty($raw)) {
            $datatable->rawColumns($raw);
        }

        return $datatable->make(true);
    }

    public function setUp()
    {
    }

    abstract public function datasource();

    abstract public function columns(): array;

    /**
     * Gets all columns, including checkboxes column.
     *
     * @return array
     */
    public function getColumns()
    {
        $columns = $this->columns();

        if ($this->checkboxes) {
            $cbid = uniqid('checkbox_');
            array_unshift($columns, Column::add(
                '<div class="icheck-primary mb-0 mt-0">
                    <input type="checkbox" name="dt-check-all" id="'.$cbid.'" autocomplete="off">
                    <label for="'.$cbid.'"></label>
                </div>'
            )
            ->notSearchable()
            ->notOrderable()
            ->data('checkbox', function ($data) {
                $cbid = uniqid('checkbox_');
                $id = $data[$this->checkboxesField] ?? '';

                return '<div class="icheck-primary mb-0">
                            <input type="checkbox" name="dt-checkbox['.$id.']" id="'.$cbid.'" autocomplete="off">
                            <label for="'.$cbid.'"></label>
                        </div>';
            }));
        }

        return $columns;
    }

    public function locale(array $locale)
    {
        $this->locale = $locale;

        return $this;
    }

    public function getLocale()
    {
        return collect(__('boilerplate::datatable'))->merge($this->locale)->toJson();
    }

    /**
     * Sets the DataTable order by column name and direction.
     *
     * @param  $column
     * @param  string  $order
     * @return $this
     */
    public function order($column, string $order = 'asc'): Datatable
    {
        if (! is_array($column)) {
            $column = [$column => $order];
        }

        $this->orderAttr = $column;

        return $this;
    }

    /**
     * Gets the column index number by column name.
     *
     * @param  $column
     * @return int|string
     */
    protected function getColumnIndex($column)
    {
        if (is_int($column)) {
            return $column;
        }

        foreach ($this->getColumns() as $k => $c) {
            if ($c->data === $column) {
                return $k;
            }
        }

        return 0;
    }

    /**
     * Set permissions.
     *
     * @param  mixed  ...$permissions
     * @return $this
     */
    public function permissions(...$permissions): Datatable
    {
        $this->permissions = is_array($permissions[0]) ? $permissions[0] : $permissions;

        return $this;
    }

    /**
     * Set buttons to show.
     *
     * @param  mixed  ...$buttons
     * @return $this
     */
    public function buttons(...$buttons): Datatable
    {
        if (is_array($buttons[0])) {
            $buttons = $buttons[0];
        }

        $this->attributes['buttons'] = collect($buttons)->filter(function ($i) {
            return in_array($i, ['filters', 'colvis', 'csv', 'excel', 'copy', 'print', 'refresh']);
        })->toArray();

        return $this;
    }

    /**
     * Get buttons to show.
     *
     * @return string
     */
    public function getButtons()
    {
        $buttons = '';

        $icons = [
            'colvis' => 'eye',
            'csv'    => 'file-csv',
            'excel'  => 'file-excel',
        ];

        foreach ($this->attributes['buttons'] as $button) {
            $buttons .= view('boilerplate::components.datatablebutton', compact('button', 'icons'))->render();
        }

        return $buttons;
    }

    /**
     * Sets attributes on all rows.
     *
     * @param  array  $rowAttr
     * @return $this
     */
    public function setRowAttr(array $rowAttr): Datatable
    {
        $this->rowAttr = $rowAttr;

        return $this;
    }

    /**
     * Sets class on all rows.
     *
     * @param  string|Closure  $rowClass
     * @return $this
     */
    public function setRowClass(string|Closure $rowClass): Datatable
    {
        $this->rowClass = $rowClass;

        return $this;
    }

    /**
     * Sets data on all rows.
     *
     * @param  array  $rowData
     * @return $this
     */
    public function setRowData(array $rowData): Datatable
    {
        $this->rowData = $rowData;

        return $this;
    }

    /**
     * Sets id on all rows.
     *
     * @param  string|Closure  $rowId
     * @return $this
     */
    public function setRowId(string|Closure $rowId): Datatable
    {
        $this->rowId = $rowId;

        return $this;
    }

    /**
     * Manual filtering.
     *
     * @param  Closure  $query
     * @return $this
     */
    public function filter(Closure $query): Datatable
    {
        $this->filter = $query;

        return $this;
    }

    /**
     * Defines the array of values to use for the length selection menu.
     *
     * @param  array  $value
     * @return $this
     */
    public function lengthMenu(array $value): Datatable
    {
        $this->attributes['lengthMenu'] = $value;

        return $this;
    }

    /**
     * Sets the paging type to use. Can be numbers, simple, simple_numbers, full, full_numbers, first_last_numbers.
     *
     * @param  $type
     * @return $this
     */
    public function pagingType($type): Datatable
    {
        if (in_array($type, ['numbers', 'simple', 'simple_numbers', 'full', 'full_numbers', 'first_last_numbers'])) {
            $this->attributes['pagingType'] = $type;
        }

        return $this;
    }

    /**
     * Sets the default page length.
     *
     * @param  int  $length
     * @return $this
     */
    public function pageLength(int $length = 10): Datatable
    {
        $this->attributes['pageLength'] = $length;

        return $this;
    }

    /**
     * Enable state saving. Stores state information such as pagination position, display length, filtering and sorting.
     *
     * @return $this
     */
    public function stateSave(): Datatable
    {
        $this->attributes['stateSave'] = true;

        return $this;
    }

    /**
     * Shows checkboxes as first column.
     *
     * @return $this
     */
    public function showCheckboxes($field = 'id')
    {
        $this->checkboxes = true;
        $this->checkboxesField = $field;

        return $this;
    }

    /**
     * Disables the paging.
     *
     * @return $this
     */
    public function noPaging(): Datatable
    {
        $this->attributes['paging'] = false;

        return $this;
    }

    /**
     * Disables the user's ability to change the paging display length.
     *
     * @return $this
     */
    public function noLengthChange(): Datatable
    {
        $this->attributes['lengthChange'] = false;

        return $this;
    }

    /**
     * Alias of noOrdering.
     *
     * @return $this
     */
    public function noSorting(): DataTable
    {
        return $this->noOrdering();
    }

    /**
     * Disable the ordering (sorting).
     *
     * @return $this
     */
    public function noOrdering(): Datatable
    {
        $this->attributes['ordering'] = false;

        return $this;
    }

    /**
     * Disables the searching.
     *
     * @return $this
     */
    public function noSearching(): Datatable
    {
        $this->attributes['searching'] = false;

        return $this;
    }

    /**
     * Disables the table information.
     *
     * @return $this
     */
    public function noInfo(): Datatable
    {
        $this->attributes['info'] = false;

        return $this;
    }

    /**
     * Table must be condensed.
     *
     * @return $this
     */
    public function condensed(): Datatable
    {
        $this->attributes['condensed'] = true;

        return $this;
    }

    /**
     * When using API, set the current offset.
     *
     * @param  int  $offset
     * @return $this
     */
    public function setOffset($offset)
    {
        $this->offset = $offset;

        return $this;
    }

    /**
     * When using API, set the current total records.
     *
     * @param  int  $total
     * @return $this
     */
    public function setTotalRecords($total)
    {
        $this->totalRecords = $total;

        return $this;
    }

    /**
     * When using API, set the filter records.
     *
     * @param  int  $filteredRecords
     * @return $this
     */
    public function setFilteredRecords(int $filteredRecords)
    {
        $this->filteredRecords = $filteredRecords;

        return $this;
    }

    /**
     * Skip Datatables paging.
     *
     * @return $this
     */
    public function skipPaging()
    {
        $this->skipPaging = true;

        return $this;
    }

    /**
     * Get a search value by the column name.
     *
     * @param  $name
     * @return mixed
     */
    protected function getRequestSearchValue($name)
    {
        $idx = $this->getColumnIndex($name);

        return request()->input('columns')[$idx]['search']['value'];
    }

    /**
     * Gets the DataTable global search value.
     *
     * @return string|null
     */
    protected function getGlobalSearchValue(): ?string
    {
        return request()->input('search.value');
    }

    /**
     * Get columns that must calculate a sum.
     *
     * @return array
     */
    public function getSumColumns(): array
    {
        $sumColumns = [];
        foreach ($this->getColumns() as $index => $column) {
            if ($column->sum) {
                $sumColumns[] = $index;
            }
        }

        return $sumColumns;
    }

    /**
     * Magic method to get property or attribute.
     *
     * @param  $name
     * @return false|mixed|string|null
     */
    public function __get($name)
    {
        if (property_exists($this, $name)) {
            return $this->$name;
        }

        if (in_array($name, ['order', 'lengthMenu'])) {
            if ($name === 'order') {
                foreach ($this->orderAttr as $c => $o) {
                    $this->attributes['order'][] = [$this->getColumnIndex($c), $o];
                }
            }

            return json_encode($this->attributes[$name]);
        }

        if ($name === 'footerCallback') {
            $sumColumns = $this->getSumColumns();
            if (! empty($sumColumns)) {
                $columnsJson = json_encode($sumColumns);

                return "function (row, data, start, end, display) {
                    var api = this.api();
                    var sumColumns = $columnsJson;

                    sumColumns.forEach(function(colIndex) {
                        var total = api
                            .column(colIndex, {page: 'current'})
                            .data()
                            .reduce(function (a, b) {
                                // Extract numeric value from HTML content if present
                                var val = b;
                                if (typeof b === 'string' && b.includes('<')) {
                                    // Extract text content from HTML tags
                                    var tempDiv = document.createElement('div');
                                    tempDiv.innerHTML = b;
                                    val = tempDiv.textContent || tempDiv.innerText || '';
                                    // Replace '.' with 0 for empty level indicators
                                    val = val === '.' ? '0' : val;
                                }
                                return a + (parseFloat(val) || 0);
                            }, 0);

                        \$(api.column(colIndex).footer()).html(total.toLocaleString());
                    });
                }";
            }

            return $this->attributes[$name];
        }

        if (isset($this->attributes[$name])) {
            return $this->attributes[$name];
        }

        return null;
    }

    /**
     * Magic method to check if property or attribute is set or not.
     *
     * @param  $name
     * @return bool
     */
    public function __isset($name)
    {
        if (property_exists($this, $name)) {
            return true;
        }

        if (isset($this->attributes[$name])) {
            return true;
        }

        return false;
    }
}
