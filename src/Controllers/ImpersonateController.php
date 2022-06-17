<?php

namespace Sebastienheyd\Boilerplate\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Sebastienheyd\Boilerplate\Models\User;

class ImpersonateController
{
    public function impersonate($id)
    {
        $user = User::find($id);

        // Guard against administrator impersonate
        if(! $user->hasRole('admin'))
        {
            Auth::user()->setImpersonating($user->id);
        }
        else
        {
            Log::error('Impersonate disabled for this user.');
        }

        return redirect()->back();
    }

    public function stopImpersonate()
    {
        Auth::user()->stopImpersonating();

        return redirect()->back();
    }

    /**
     * Get users to impersonate.
     */
    public function selectImpersonate(Request $request)
    {
        return response()->json([
            'results' => User::selectRaw('id as id, CONCAT(first_name, \' \', last_name) as text')
                ->where('active', 1)
                ->where('first_name', 'like', '%'.$request->input('q').'%')
                ->orWhere('last_name', 'like', '%'.$request->input('q').'%')
                ->get()->toArray()
        ]);
    }
}