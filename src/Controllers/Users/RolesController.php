<?php

namespace Sebastienheyd\Boilerplate\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Sebastienheyd\Boilerplate\Models\Permission;
use Sebastienheyd\Boilerplate\Models\Role;

class RolesController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Roles Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the roles and permission management.
    |
    */

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('ability:admin,roles_crud');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('boilerplate::roles.list', ['roles' => Role::all()]);
    }

    /**
     * Show the form for creating a new role.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('boilerplate::roles.create', ['permissions' => Permission::all()]);
    }

    /**
     * Store a newly created role in storage.
     *
     * @param Request $request
     *
     * @throws \Illuminate\Validation\ValidationException
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $input['name'] = Str::slug($input['display_name']);
        $request->replace($input);

        $this->validate($request, [
            'name'         => 'required|unique:roles,name',
            'display_name' => 'required',
            'description'  => 'required',
        ], [], [
            'display_name' => mb_strtolower(__('boilerplate::role.label')),
            'description'  => mb_strtolower(__('boilerplate::role.description'))
        ]);

        $role = Role::create($input);
        $role->permissions()->sync(array_keys($request->input('permission', [])));

        return redirect()->route('boilerplate.roles.edit', $role)
                         ->with('growl', [__('boilerplate::role.successadd'), 'success']);
    }

    /**
     * Show the form for editing the specified role.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::find($id);
        $permissions = Permission::all();

        return view('boilerplate::roles.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified role in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'display_name' => 'required',
            'description'  => 'required',
        ], [], [
            'display_name' => mb_strtolower(__('boilerplate::role.label')),
            'description'  => mb_strtolower(__('boilerplate::role.description'))
        ]);

        $role = Role::find($id);
        $role->update($request->all());
        $role->permissions()->sync(array_keys($request->input('permission')));

        return redirect()->route('boilerplate.roles.edit', $role)
                         ->with('growl', [__('boilerplate::role.successmod'), 'success']);
    }

    /**
     * Remove the specified role from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Role::destroy($id);
    }
}
