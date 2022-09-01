<?php

namespace App\Http\Controllers\Dashboard\General;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminRoleRequest;
use App\Models\Role;
use Illuminate\Http\Request;

class AdminRolesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:read-roles'])->only('index');
        $this->middleware(['permission:create-roles'])->only('create');
        $this->middleware(['permission:update-roles'])->only('edit');
        $this->middleware(['permission:delete-roles'])->only('delete');
    }

    public function index()
    {
        try {
            $roles = Role::latest('id')->get();
            return view('admin.general.roles.index', compact('roles'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function create()
    {
        return view('admin.general.roles.create');
    }

    public function store(AdminRoleRequest $request)
    {
        try {
            //create role
            $request_data = $request->except(['_token', 'permissions']);
            $request_data['is_admin_user'] = 1;
//            return $request->permissions;
            $role = Role::create($request_data);
            $role->attachPermissions($request->permissions);

            return redirect()->route('admin-roles.index')->with(['success' => __('message.created_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function show($id)
    {
        try {
            $role = Role::find($id);
            return view('admin.general.roles.show', compact('role'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function edit($id)
    {
        try {
            $role = Role::find($id);
            return view('admin.general.roles.edit', compact('role'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function update(AdminRoleRequest $request, $id)
    {
        try {
            $role = Role::find($id);
            if ($role->name_en == 'super admin' || $role->id == 1)
                return redirect()->back()->with(['error' => __('message.error_admin_role_update')]);
            $request_data = $request->except(['_token', 'permissions']);
            //update role
            $role->update($request_data);
            $role->syncPermissions($request->permissions); //update role permassion
            return redirect()->route('admin-roles.index')->with(['success' => __('message.updated_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function destroy($id)
    {
        try {
            $role = Role::find($id);
            if ($role->name_en == 'super admin' || $role->id == 1)
                return redirect()->back()->with(['error' => __('message.error_admin_role_delete')]);

            $role->delete();
            return redirect()->route('admin-roles.index')->with(['success' => __('message.deleted_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }
}
