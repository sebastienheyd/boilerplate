<?php namespace Sebastienheyd\Boilerplate\Controllers\Logs;

use Arcanedev\LogViewer\Http\Controllers\LogViewerController as ArcanedevController;
use Arcanedev\LogViewer\Contracts\LogViewer as LogViewerContract;

class LogViewerController extends ArcanedevController
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(LogViewerContract $logViewer)
    {
        $this->middleware('ability:admin,logs');
        return parent::__construct($logViewer);
    }

    protected $showRoute = 'logs.show';

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    protected function view($view, $data = [ ], $mergeData = [ ])
    {
        return view('boilerplate::logs.'.$view, $data, $mergeData);
    }
}
