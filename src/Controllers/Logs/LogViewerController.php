<?php namespace Sebastienheyd\Boilerplate\Controllers\Logs;

use Arcanedev\LogViewer\Http\Controllers\LogViewerController as ArcanedevController;
use Illuminate\Http\Request;

class LogViewerController extends ArcanedevController
{
    protected $showRoute = 'logs.show';

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    protected function view($view, $data = [], $mergeData = [])
    {
        return view('boilerplate::logs.'.$view, $data, $mergeData);
    }
}
