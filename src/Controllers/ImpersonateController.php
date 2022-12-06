<?php

namespace Sebastienheyd\Boilerplate\Controllers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

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
        $userModel = config('auth.providers.users.model');
        $user = $userModel::find($request->post('id'));

        $error = false;

        if (! Auth::user()->hasRole('admin')) {
            $error = 'Only admins can use the impersonate feature.';
        } elseif ($user->hasRole('admin')) {
            $error = 'Cannot impersonate an admin.';
        } elseif (! $user->hasPermission('backend_access')) {
            $error = 'Selected user does not have backend access.';
        } else {
            Session::put('impersonate', $user->id);
        }

        if ($error) {
            Log::error($error);

            return response()->json([
                'success' => false,
                'message' => $error,
            ]);
        }

        return response()->json([
            'success' => true,
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
        $userModel = config('auth.providers.users.model');

        return response()->json([
            'results' => $userModel::with('roles', 'permissions')
                ->select('id', 'first_name', 'last_name')
                ->where('active', 1)
                ->where('id', '!=', Auth::id())
                ->whereDoesntHave('roles', function ($query) {
                    $query->where('name', '=', 'admin');
                })
                ->whereHas('permissions', function ($query) {
                    $query->where('name', '=', 'backend_access');
                })
                ->where(function ($query) use ($request) {
                    $query->where('first_name', 'like', '%'.$request->input('q').'%')
                          ->orWhere('last_name', 'like', '%'.$request->input('q').'%');
                })
                ->limit(10)
                ->get()
                ->mapWithKeys(function ($item, $key) {
                    return [
                        'id'   => $item['id'],
                        'text' => $item['first_name'].' '.$item['last_name']
                    ];
                })
                ->toArray(),
        ]);
    }
}
