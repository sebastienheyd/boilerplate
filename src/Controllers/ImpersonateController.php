<?php

namespace Sebastienheyd\Boilerplate\Controllers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Sebastienheyd\Boilerplate\Models\User;

class ImpersonateController
{
    /**
     * Check if the current user is allowed to impersonate others and if the user they are trying to impersonate has
     * backend access rights, then switch to that user's point of view.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function impersonate(Request $request): JsonResponse
    {
        $user = User::find($request->post('id'));

        if (! Auth::user()->hasRole('admin')) {
            Log::error('Only admins can use the impersonate feature.');
            $success = false;
        } elseif ($user->hasRole('admin')) {
            Log::error('Cannot impersonate an admin.');
            $success = false;
        } elseif (! $user->hasPermission('backend_access')) {
            Log::error('Selected user does not have backend access.');
            $success = false;
        } else {
            Session::put('impersonate', $user->id);
            $success = true;
        }

        return response()->json([
            'success' => $success,
        ]);
    }

    /**
     * Stop impersonating the user and return to admin point of view.
     */
    public function stopImpersonate(): RedirectResponse
    {
        if (Session::has('impersonate')) {
            Session::forget('impersonate');
        }

        return redirect()->back();
    }

    /**
     * Get the list of eligible users to impersonate.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function selectImpersonate(Request $request): JsonResponse
    {
        // Retrieve id of all admin
        $adminId = User::with('roles')->select('id')->whereHas('roles', function (Builder $query) {
            $query->where('name', '=', 'admin');
        })->pluck('id')->toArray();

        return response()->json([
            'results' => User::with('roles')->selectRaw('id, CONCAT(first_name, \' \', last_name) as text')
                ->where('active', 1)
                ->where('id', '!=', Auth::id())
                ->whereNotIn('id', $adminId)
                ->whereHas('roles', function ($query) {
                    $query->where('name', '=', 'backend_user');
                })
                ->where(function ($query) use ($request) {
                    $query->where('first_name', 'like', '%'.$request->input('q').'%')
                          ->orWhere('last_name', 'like', '%'.$request->input('q').'%');
                })
                ->limit(10)
                ->get()->toArray(),
        ]);
    }
}
