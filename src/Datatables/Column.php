<?php

namespace Sebastienheyd\Boilerplate\Datatables;

use Closure;

class Column
{
    protected $actions = [];
    protected $attributes = [];
    protected $filter = null;
    protected $filterOptions = [];
    protected $filterType = 'input';
    protected $order = null;
    protected $raw = null;
    protected $title = '';

    /**
     * Instanciate a new column.
     *
     * @param  string  $title
     */
    public function __construct(string $title)
    {
        $this->title = $title;
    }

    /**
     * Add a new column to the DataTable.
     *
     * @param  string  $title
     * @return Column
     */
    public static function add(string $title = ''): Column
    {
        return new static($title);
    }

    /**
     * Get attributes used by the DataTable initialization script.
     *
     * @return string
     */
    public function get(): string
    {
        $attributes = [];
        foreach ($this->attributes as $k => $v) {
            if (is_string($v)) {
                $attributes[] = "$k:\"$v\"";
            } elseif ($v instanceof Closure) {
                $attributes[] = "$k:".$v();
            } elseif (is_bool($v)) {
                $attributes[] = "$k:".($v ? 'true' : 'false');
            } else {
                $attributes[] = "$k:".intval($v);
            }
        }

        return '{'.implode(',', $attributes).'}';
    }

    /**
     * Set the property to use as data source. Property can be formatted by using a Closure.
     *
     * @param  string  $name
     * @param  Closure|null  $format
     * @return $this
     */
    public function data(string $name, Closure $format = null): Column
    {
        $this->attributes['data'] = $name;

        if ($format !== null) {
            $this->raw = $format;
        }

        return $this;
    }

    /**
     * Define an array of options to be used by the filter select.
     *
     * @param $filterOptions
     * @param  string  $filterType
     * @return $this
     */
    public function filterOptions($filterOptions, bool $multiple = false): Column
    {
        if (is_array($filterOptions)) {
            $this->filterOptions = $filterOptions;
        }

        if ($filterOptions instanceof Closure) {
            $this->filterOptions = $filterOptions->call($this);
        }

        $this->filterType($multiple ? 'select-multiple' : 'select');

        return $this;
    }

    /**
     * For dates, convert the date to a "From Now" format.
     *
     * @return $this
     */
    public function fromNow(): Column
    {
        return $this->dateFormat(function () {
            return '$.fn.dataTable.render.fromNow()';
        });
    }

    /**
     * For dates, convert the date to the given format. Default format is "YYYY-MM-DD HH:mm:ss".
     *
     * @param  null  $format
     * @return $this
     */
    public function dateFormat($format = null): Column
    {
        if ($format === null) {
            $format = __('boilerplate::date.YmdHis');
        }

        if (is_string($format)) {
            $format = function () use ($format) {
                return "$.fn.dataTable.render.moment('$format')";
            };
        }

        if ($format instanceof Closure) {
            $this->attributes['render'] = $format;
        }

        $this->filter(function ($query, $q) {
            if (preg_match('#^[0-9]{4}-[0-9]{2}-[0-9]{2}\s[0-9]{2}:[0-9]{2}:[0-9]{2}|[0-9]{4}-[0-9]{2}-[0-9]{2}\s[0-9]{2}:[0-9]{2}:[0-9]{2}$#', $q)) {
                [$start, $end] = explode('|', $q);
                $query->whereBetween($this->name ?? $this->data, [$start, $end]);
            }
        });

        $this->filterType('daterangepicker');

        return $this;
    }

    /**
     * Define the filter type.
     *
     * @param  string  $type
     * @return $this
     */
    public function filterType(string $type = 'text'): Column
    {
        if (in_array($type, ['text', 'daterangepicker', 'select', 'select-multiple'])) {
            $this->filterType = $type;
        }

        return $this;
    }

    /**
     * Filter to use for custom searches.
     *
     * @param  Closure  $filter
     * @return $this
     */
    public function filter(Closure $filter): Column
    {
        $filter = Closure::bind($filter, $this);
        $this->filter = $filter;

        return $this;
    }

    /**
     * Order to use for custom searches.
     *
     * @param  Closure  $order
     * @return $this
     */
    public function order(Closure $order): Column
    {
        $order = Closure::bind($order, $this);
        $this->order = $order;

        return $this;
    }

    /**
     * Alias for actions column.
     *
     * @param  Closure  $actions
     * @return $this
     */
    public function actions(Closure $actions): Column
    {
        $this->data('dt-actions', $actions)->class('visible-on-hover text-nowrap')->notSearchable()->notOrderable();

        return $this;
    }

    /**
     * Column class.
     *
     * @param  string  $class
     * @return $this
     */
    public function class(string $class): Column
    {
        $this->attributes['class'] = $class;

        return $this;
    }

    /**
     * For eager loaded relationships, specify the relation.column_name to use.
     *
     * @param  string  $name
     * @return $this
     */
    public function name(string $name): Column
    {
        $this->attributes['name'] = $name;

        return $this;
    }

    /**
     * Specify the column width.
     *
     * @param  string  $width
     * @return $this
     */
    public function width(string $width): Column
    {
        $this->attributes['width'] = $width;

        return $this;
    }

    /**
     * Column must be hidden.
     *
     * @return Column
     */
    public function hidden(): Column
    {
        return $this->booleanAttribute('visible', false);
    }

    /**
     * Setting a boolean attribute.
     *
     * @param $name
     * @param $value
     * @return Column
     */
    private function booleanAttribute($name, $value): Column
    {
        $this->attributes[$name] = false;

        if ($value === true) {
            unset($this->attributes[$name]);
        }

        return $this;
    }

    /**
     * Column content must not be searchable.
     *
     * @return Column
     */
    public function notSearchable(): Column
    {
        return $this->booleanAttribute('searchable', false);
    }

    /**
     * Column content must not be orderable. Alias of notOrderable.
     *
     * @return Column
     */
    public function notSortable(): Column
    {
        return $this->notOrderable();
    }

    /**
     * Column content must not be orderable.
     *
     * @return Column
     */
    public function notOrderable(): Column
    {
        return $this->booleanAttribute('orderable', false);
    }

    /**
     * Magic method to get properties or attributes.
     *
     * @param $name
     * @return mixed|null
     */
    public function __get($name)
    {
        if (property_exists($this, $name)) {
            return $this->$name;
        }

        if (isset($this->attributes[$name])) {
            return $this->attributes[$name];
        }

        return null;
    }

    /**
     * Magic method to know if magic property or attribute is set.
     *
     * @param $name
     * @return bool
     */
    public function __isset($name)
    {
        if (property_exists($this, $name)) {
            return ! empty($this->$name);
        }

        return isset($this->attributes[$name]);
    }
}
