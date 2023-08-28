<?php

namespace Sebastienheyd\Boilerplate\Dashboard\Widgets;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Sebastienheyd\Boilerplate\Dashboard\Widget;

class LatestErrors extends Widget
{
    protected $slug = 'latest-errors';
    protected $label = 'boilerplate::dashboard.latest-errors.label';
    protected $description = 'boilerplate::dashboard.latest-errors.description';
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

        $files = array_reverse(glob($path.'-*'));

        $errors = [];
        $isError = false;
        $i = 0;

        foreach ($files as $file) {
            $handle = fopen($file, 'r');
            if ($handle) {
                while (($buffer = fgets($handle)) !== false) {
                    if (preg_match('#^\[([^\]]+)\]\s([^\.]+)\.ERROR:\s([^\n]+)#', $buffer, $m)) {
                        $i++;
                        $isError = true;

                        $message = preg_replace("#\{(.*)$#", '', $m[3]);

                        $errors[$i] = [
                            'date' => Date::createFromFormat('Y-m-d H:i:s', $m[1])->isoFormat(__('boilerplate::date.YmdHis')),
                            'message' => $message,
                        ];
                    } else {
                        if ($isError) {
                            if (trim($buffer) === '"}') {
                                $isError = false;

                                if (count($errors) == $length) {
                                    fclose($handle);
                                    break 2;
                                }

                                continue;
                            }

                            if (preg_match('`^#[0-9]+\s(.*)`', $buffer, $m)) {
                                if (preg_match('#^([^\(]+)\(([0-9]+)\):\s(.*)$#', str_replace(base_path(), '', $m[1]), $n)) {
                                    $errors[$i]['stack'][] = [
                                        'path' => $n[1],
                                        'line' => $n[2],
                                        'function' => $n[3],
                                    ];
                                } else {
                                    $errors[$i]['stack'][] = [
                                        'path' => '',
                                        'line' => '',
                                        'function' => $m[1],
                                    ];
                                }
                            }
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
            'length' => 'required|integer|min:1|max:6',
        ], [], [
            'length' => __('Length'),
        ]);
    }
}
