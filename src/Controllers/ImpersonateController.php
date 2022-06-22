<?php
/**
 * Do not warn about magic access of properties.
 *
 * @noinspection PhpUndefinedFieldInspection
 */

/**
 * Do not warn of multiple class definitions.
 *
 * @noinspection PhpMultipleClassDeclarationsInspection
 */

namespace Sebastienheyd\Boilerplate\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Sebastienheyd\Boilerplate\Models\User;

class ImpersonateController
{
    /**
     * Check if the current user is allowed to impersonate others and if the user they are trying to impersonate has
     * backend access rights, then switch to that user's point of view.
     *
     * @param $id
     *
     * @return JsonResponse
     * @author Christopher Walker
     */
    public function impersonate($id): JsonResponse
    {
        $user = User::find($id);

        // Guard against non-admins impersonating
        if (!Auth::user()->hasRole('admin')) {
            Log::error('Only admins can use the impersonate feature.');
            $msg = __('boilerplate::impersonate.errors.insufficient_permissions');
            $success = false;
        } elseif ($user->hasRole('admin')) { // Guard against impersonating an admin
            Log::error('Cannot impersonate an admin.');
            $msg = __('boilerplate::impersonate.errors.no_impersonating_admins');
            $success = false;
        } elseif (!$user->hasPermission('backend_access')) { // Guard against impersonating users without backend access
            Log::error('Selected user does not have backend access.');
            $msg = __('boilerplate::impersonate.errors.no_backend_access');
            $success = false;
        } else {
            Auth::user()->setImpersonating($user->id);
            $msg = __('boilerplate::impersonate.impersonate_success');
            $success = true;
        }

        return response()->json([
            'success' => $success,
            'msg' => $msg,
        ]);
    }

    /**
     * Stop impersonating the user and return to admin point of view.
     *
     * @return RedirectResponse
     * @author Christopher Walker
     */
    public function stopImpersonate(): RedirectResponse
    {
        Auth::user()->stopImpersonating();

        return redirect()->back();
    }

    /**
     * Get the list of eligible users to impersonate. (Users must be active and have backend access).
     *
     * @param  Request  $request
     *
     * @return JsonResponse
     * @author Christopher Walker
     */
    public function selectImpersonate(Request $request): JsonResponse
    {
        return response()->json([
            'results' => User::selectRaw('id as id, CONCAT(first_name, \' \', last_name) as text')
                ->where('active', 1)
                ->where('first_name', 'like', '%'.$request->input('q').'%')
                ->orWhere('last_name', 'like', '%'.$request->input('q').'%')
                ->get()->toArray(),
        ]);
    }
}
