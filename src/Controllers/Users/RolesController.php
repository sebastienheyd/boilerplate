<?php

namespace Sebastienheyd\Boilerplate\Controllers\Users;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

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
     *
     * @return void
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $input['name'] = str_slug($input['display_name']);
        $request->replace($input);

        $this->validate($request, [
            'name' => 'required|unique:roles,name',
            'display_name' => 'required',
            'description' => 'required'
        ]);

        $role = Role::create($input);
        $role->permissions()->sync(array_keys($request->input('permission', [])));

        return redirect()->route('roles.edit', $role)->with('growl', [__('boilerplate::role.successadd'), 'success']);
    }

    /**
     * Display the specified role.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect()->route('roles.edit', $id);
    }

    /**
     * Show the form for editing the specified role.
     *
     * @param  int  $id
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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();
        $input['name'] = str_slug($input['display_name']);
        $request->replace($input);

        $this->validate($request, [
            'name' => "required|unique:roles,name,$id",
            'display_name' => 'required',
            'description' => 'required'
        ]);

        $role = Role::find($id);
        $role->update($request->all());
        $role->permissions()->sync(array_keys($request->input('permission')));

        return redirect()->route('roles.edit', $role)->with('growl', [__('boilerplate::role.successmod'), 'success']);
    }

    /**
     * Remove the specified role from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Role::destroy($id);
    }
}
