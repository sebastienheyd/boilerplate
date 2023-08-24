<?php

namespace Sebastienheyd\Boilerplate\Dashboard\Widgets;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Sebastienheyd\Boilerplate\Dashboard\Widget;
use Sebastienheyd\Boilerplate\Models\User;

class LatestErrors extends Widget
{
    protected $slug = 'latest-errors';
    protected $label = "Latest errors";
    protected $description = "Shows latest logged errors.";
    protected $permission = 'logs';
    protected $size = 'sm';
    protected $view = 'boilerplate::dashboard.widgets.latestErrors';
    protected $editView = 'boilerplate::dashboard.widgets.latestErrorsEdit';
    protected $parameters = [
        'length' => 3,
        'color'  => 'danger',
    ];

    public function make()
    {
        $this->assign('errors', $this->getErrorslist($this->get('length')));
    }

    private function getErrorslist($length = 3)
    {
        $path = str_replace('.log', '', config('logging.channels.daily.path'));

        $files = array_reverse(glob($path . '-*'));

        $errors = [];

        foreach ($files as $file) {
            $handle = fopen($file, "r");
            if ($handle) {
                while (($buffer = fgets($handle)) !== false) {
                    if (preg_match('#^\[([^\]]+)\]\s([^\.]+)\.ERROR:\s([^\n]+)#', $buffer, $m)) {
                        $errors[$m[1]] = ['date' => Date::createFromFormat('Y-m-d H:i:s', $m[1])->isoFormat(__('boilerplate::date.YmdHis')), 'message' => $m[3]];
                        if (count($errors) == $length) {
                            fclose($handle);
                            break 2;
                        }
                    }
                }
                fclose($handle);
            }
        }

        krsort($errors);

        return $errors;
    }

    public function validator(Request $request)
    {
        return validator()->make($request->post(), [
            'length' => 'required|integer|min:1|max:6'
        ], [], [
            'length' => __('Length'),
        ]);
    }
}