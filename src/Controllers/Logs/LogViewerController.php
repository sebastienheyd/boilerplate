<?php

namespace Sebastienheyd\Boilerplate\Controllers\Logs;

use Illuminate\Http\Request;
use Sebastienheyd\Boilerplate\Models\LogFile;

class LogViewerController
{
    public function index()
    {
        $logs = LogFile::files();
        $levels = LogFile::$levels;

        $stats = [];
        foreach ($logs as $logFile) {
            $log = LogFile::get($logFile);
            $stats[$logFile] = $log->stats();
        }

        return view('boilerplate::logs.index', compact('stats', 'levels'));
    }

    public function show(string $date)
    {
        try {
            $log = LogFile::get("laravel-$date.log");
        } catch (\Exception $e) {
            abort(404);
        }

        $stats = $log->stats();

        return view('boilerplate::logs.show', compact('stats'));
    }

    public function download(string $date)
    {
        try {
            $log = LogFile::get("laravel-$date.log");
        } catch (\Exception $e) {
            abort(404);
        }

        return $log->download();
    }

    public function delete(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
        ]);

        $date = $validated['date'];

        try {
            $log = LogFile::get("laravel-$date.log");
        } catch (\Exception $e) {
            abort(404);
        }

        $deleted = $log->delete();

        return response()->json([
            'success' => $deleted,
        ]);
    }
}
