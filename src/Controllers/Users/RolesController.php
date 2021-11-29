<?php

namespace Sebastienheyd\Boilerplate\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('boilerplate::roles.list');
    }

    /**
     * Show the form for creating a new role.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        $permModel = config('boilerplate.laratrust.permission');
        $permissions = $permModel::with('category')->orderBy('category_id')->get();
        $permissions = $permissions->groupBy('category_id');

        $permissions_categories = [];
        foreach ($permissions as $perms) {
            $perms = $perms->filter(function ($perm) {
                return config('boilerplate.app.logs', true) || $perm->name !== 'logs';
            });

            $name = $perms->first()->category->display_name ?? __('boilerplate::permissions.categories.default');
            $permissions_categories[] = (object) [
                'name'        => $name,
                'permissions' => $perms,
            ];
        }

        return view('boilerplate::roles.create', compact('permissions_categories'));
    }

    /**
     * Store a newly created role in storage.
     *
     * @param  Request  $request
     * @return RedirectResponse
     *
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $input['name'] = Str::slug($input['display_name'], '_');
        $request->replace($input);

        $this->validate($request, [
            'name'         => 'required|unique:roles,name',
            'display_name' => 'required',
            'description'  => 'required',
        ], [], [
            'display_name' => mb_strtolower(__('boilerplate::role.label')),
            'description'  => mb_strtolower(__('boilerplate::role.description')),
        ]);

        $roleModel = config('boilerplate.laratrust.role');
        $role = $roleModel::create($input);
        $role->permissions()->sync(array_keys($request->input('permission', [])));

        return redirect()->route('boilerplate.roles.edit', $role)
                         ->with('growl', [__('boilerplate::role.successadd'), 'success']);
    }

    /**
     * Show the form for editing the specified role.
     *
     * @param  int  $id
     * @return Application|Factory|View
     */
    public function edit($id)
    {
        $roleModel = config('boilerplate.laratrust.role');
        $role = $roleModel::findOrFail($id);
        $permModel = config('boilerplate.laratrust.permission');
        $permissions = $permModel::with('category')->orderBy('category_id')->get();
        $permissions = $permissions->groupBy('category_id');

        $permissions_categories = [];
        foreach ($permissions as $perms) {
            $name = $perms->first()->category->display_name ?? __('boilerplate::permissions.categories.default');
            $permissions_categories[] = (object) [
                'name'        => $name,
                'permissions' => $perms,
            ];
        }

        return view('boilerplate::roles.edit', compact('role', 'permissions_categories'));
    }

    /**
     * Update the specified role in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return RedirectResponse
     */
    public function update($id, Request $request)
    {
        $this->validate($request, [
            'display_name' => 'required',
            'description'  => 'required',
        ], [], [
            'display_name' => mb_strtolower(__('boilerplate::role.label')),
            'description'  => mb_strtolower(__('boilerplate::role.description')),
        ]);

        $roleModel = config('boilerplate.laratrust.role');
        $role = $roleModel::find($id);
        $role->update($request->all());
        $role->permissions()->sync(array_keys($request->input('permission', [])));

        return redirect()->route('boilerplate.roles.edit', $role)
                         ->with('growl', [__('boilerplate::role.successmod'), 'success']);
    }

    /**
     * Remove the specified role from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $roleModel = config('boilerplate.laratrust.role');
        $role = $roleModel::findOrFail($id);
        $role->delete();
    }
}
