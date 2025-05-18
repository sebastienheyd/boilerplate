<?php

namespace Sebastienheyd\Boilerplate\Datatables\Admin;

use Sebastienheyd\Boilerplate\Datatables\Button;
use Sebastienheyd\Boilerplate\Datatables\Column;
use Sebastienheyd\Boilerplate\Datatables\Datatable;
use Sebastienheyd\Boilerplate\Models\LogFile;

class LogsDatatable extends Datatable
{
    public $slug = 'logs';

    public function datasource()
    {
        $logs = LogFile::files();

        $stats = [];
        foreach ($logs as $logFile) {
            $log = LogFile::get($logFile);
            $stats[$logFile] = $log->stats();
        }

        return collect($stats);
    }

    public function setUp()
    {
        $this->permissions('logs')
            ->locale([
                'deleteConfirm' => __('boilerplate::role.list.confirmdelete'),
                'deleteSuccess' => __('boilerplate::role.list.deletesuccess'),
            ])
            ->buttons([])
            ->noSearching()
            ->order('date', 'asc');
    }

    private function formatLevel($level, $log)
    {
        if ($log['levels'][$level] > 0) {
            return '<span class="text font-weight-bold text-'.strtolower($level).'">'.$log['levels'][$level].'</span>';
        }

        return '<span class="text-muted">.</span>';
    }

    public function columns(): array
    {
        return [
            Column::add(__('Date'))
                ->class('text-nowrap')
                ->data('date', function ($log) {
                    return mb_convert_case($log['date']->isoFormat(__('boilerplate::date.lFdY')), MB_CASE_TITLE);
                }),

            Column::add(__('boilerplate::logs.show.size'))
                ->class('text-nowrap')
                ->data('size', function ($log) {
                    return $log['sizeFormatted'];
                }),

            Column::add(__('boilerplate::logs.show.logentries'))
                ->width('8%')
                ->data('entries'),

            Column::add('<span class="badge level-emergency">Emergency</span>')
                ->width('8%')
                ->data('levels.EMERGENCY', function ($log) {
                    return $this->formatLevel('EMERGENCY', $log);
                }),

            Column::add('<span class="badge level-alert">Alert</span>')
                ->width('8%')
                ->data('levels.ALERT', function ($log) {
                    return $this->formatLevel('ALERT', $log);
                }),

            Column::add('<span class="badge level-critical">Critical</span>')
                ->width('8%')
                ->data('levels.CRITICAL', function ($log) {
                    return $this->formatLevel('CRITICAL', $log);
                }),

            Column::add('<span class="badge level-error">Error</span>')
                ->width('8%')
                ->data('levels.ERROR', function ($log) {
                    return $this->formatLevel('ERROR', $log);
                }),

            Column::add('<span class="badge level-warning">Warning</span>')
                ->width('8%')
                ->data('levels.WARNING', function ($log) {
                    return $this->formatLevel('WARNING', $log);
                }),

            Column::add('<span class="badge level-notice">Notice</span>')
                ->width('8%')
                ->data('levels.NOTICE', function ($log) {
                    return $this->formatLevel('NOTICE', $log);
                }),

            Column::add('<span class="badge level-info">Info</span>')
                ->width('8%')
                ->data('levels.INFO', function ($log) {
                    return $this->formatLevel('INFO', $log);
                }),

            Column::add('<span class="badge level-debug">Debug</span>')
                ->width('8%')
                ->data('levels.DEBUG', function ($log) {
                    return $this->formatLevel('DEBUG', $log);
                }),

            Column::add()
                ->width('20px')
                ->actions(function ($log) {
                    $buttons = Button::show('boilerplate.logs.show', $log['date']->format('Y-m-d'));
                    $buttons .= Button::add()
                        ->route('boilerplate.logs.delete')
                        ->attributes([
                            'data-action' => 'delete-log',
                            'data-date' => $log['date']->format('Y-m-d'),
                        ])
                        ->color('danger')
                        ->icon('trash')
                        ->make();
                    return $buttons;
                }),
        ];
    }
}
