<?php

namespace Sebastienheyd\Boilerplate\Controllers\Logs;

use Arcanedev\LogViewer\Contracts\LogViewer as LogViewerContract;
use Arcanedev\LogViewer\Http\Controllers\LogViewerController as ArcanedevController;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class LogViewerController extends ArcanedevController
{
    protected $showRoute = 'boilerplate.logs.show';

    /**
     * LogViewerController constructor.
     *
     * @param  LogViewerContract  $logViewer
     */
    public function __construct(LogViewerContract $logViewer)
    {
        $this->middleware('ability:admin,logs');

        if (!config('boilerplate.app.logs')) {
            abort('404');
        }

        parent::__construct($logViewer);
    }

    /**
     * Get overloaded view.
     *
     * @param  string  $view
     * @param  array   $data
     * @param  array   $mergeData
     * @return Application|Factory|View
     */
    protected function view($view, $data = [], $mergeData = [])
    {
        return view('boilerplate::logs.'.$view, $data, $mergeData);
    }
}
