<?php

namespace Sebastienheyd\Boilerplate\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class PwaController extends Controller
{
    public function manifest(): JsonResponse
    {
        if (!config('boilerplate.app.pwa.enabled', false)) {
            abort(404);
        }

        $config = config('boilerplate.app.pwa');
        $prefix = config('boilerplate.app.prefix', '');
        $domain = config('boilerplate.app.domain', '');

        $baseUrl = $domain ? "https://{$domain}" : url('/');
        $startUrl = $prefix ? "/{$prefix}" : '/';
        $scope = $prefix ? "/{$prefix}/" : '/';

        $manifest = [
            'name' => $config['name'],
            'short_name' => $config['short_name'],
            'description' => $config['description'],
            'start_url' => $baseUrl.$startUrl,
            'scope' => $baseUrl.$scope,
            'display' => $config['display'],
            'orientation' => $config['orientation'],
            'theme_color' => $config['theme_color'],
            'background_color' => $config['background_color'],
            'icons' => []
        ];

        if (empty($config['description'])) {
            unset($manifest['description']);
        }

        foreach ($config['icons'] as $icon) {
            $manifest['icons'][] = [
                'src' => asset($icon['src']),
                'sizes' => $icon['sizes'],
                'type' => $icon['type']
            ];
        }

        return response()->json($manifest);
    }
}