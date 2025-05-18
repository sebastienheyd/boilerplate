<?php

namespace Sebastienheyd\Boilerplate\Datatables\Admin;

use Sebastienheyd\Boilerplate\Datatables\Button;
use Sebastienheyd\Boilerplate\Datatables\Column;
use Sebastienheyd\Boilerplate\Datatables\Datatable;
use Sebastienheyd\Boilerplate\Models\LogFile;

class LogFileDatatable extends Datatable
{
    public $slug = 'log';

    public function datasource()
    {
        $date = request()->post('log');

        if (!$date) {
            abort(404);
        }

        try {
            $log = LogFile::get("laravel-$date.log");
        } catch (\Exception $e) {
            abort(404);
        }

        return collect($log->parse());
    }

    public function setUp()
    {
        $this->permissions('logs')
            ->order('date', 'desc');
    }

    private function formatLevel($level)
    {
        return '<span class="badge level-'.strtolower($level).'">'.ucfirst(strtolower($level)).'</span>';
    }

    public function columns(): array
    {
        return [
            Column::add(__('boilerplate::logs.show.level'))
                ->class('text-nowrap')
                ->width('80px')
                ->filterOptions(function () {
                    return [
                        'debug' => 'Debug',
                        'info' => 'Info',
                        'notice' => 'Notice',
                        'warning' => 'Warning',
                        'error' => 'Error',
                        'critical' => 'Critical',
                        'alert' => 'Alert',
                        'emergency' => 'Emergency',
                    ];
                })
                ->data('type', function ($log) {
                    return $this->formatLevel($log['type']);
                }),

            Column::add(__('boilerplate::logs.show.time'))
                ->class('text-nowrap')
                ->notSearchable()
                ->data('date', function ($log) {
                    return $log['date']->format('H:i:s');
                }),

            Column::add(__('boilerplate::logs.show.logentries'))
                ->notSortable()
                ->data('message'),

            Column::add()
                ->notSortable()
                ->notSearchable()
                ->data('stacktrace', function ($log) {
                    if (! empty($log['stacktrace'])) {
                        return '<button class="btn btn-xs btn-default show-stack">Stack</button>
                                <div class="stacktrace d-none"><div class="stack-content"><div class="mb-2">'.implode('</div><div class="mb-2">', $log['stacktrace']).'</div></div>';
                    }
                }),
        ];
    }
}
