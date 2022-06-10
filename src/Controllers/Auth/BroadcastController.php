<?php

namespace Sebastienheyd\Boilerplate\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Pusher\Pusher;

class BroadcastController extends Controller
{
    public function pusherAuth(Request $request)
    {
        try {
            $pusher = new Pusher(
                config('broadcasting.connections.pusher.key'),
                config('broadcasting.connections.pusher.secret'),
                config('broadcasting.connections.pusher.app_id'),
                ['cluster' => config('broadcasting.connections.pusher.options.cluster', 'eu'), 'encrypted' => true]
            );
        } catch (\Exception $e) {
            return false;
        }

        $login = json_decode($pusher->socketAuth($request->post('channel_name'), $request->post('socket_id')));

        return response()->json($login);
    }
}
