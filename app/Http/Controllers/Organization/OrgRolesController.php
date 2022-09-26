<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminRoleRequest;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrgRolesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['HasOrgRoles:read'])->only(['index', 'show']);
        $this->middleware(['HasOrgRoles:update'])->only('edit');
        $this->middleware(['HasOrgRoles:create'])->only('create');
        $this->middleware(['HasOrgRoles:delete'])->only('destroy');
    }

    public function index()
    {
        try {
            $user = Auth::guard('web')->user();
            $model_type = $user->organizable_type;
            $model_id = $user->organizable_id;
            $model = new $model_type;
            $data = $model->find($model_id);
            $roles = $data->roles()->latest('id')->get();
            return view('organization.users.roles.index', compact('roles'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function create()
    {
        return view('organization.users.roles.create');
    }

    public function store(AdminRoleRequest $request)
    {
        try {
            //create role
            $request_data = $request->except(['_token', 'permissions']);
            $request_data['created_by'] = auth('admin')->user()->email;
//            return $request->permissions;
            $role = Role::create($request_data);
            $role->attachPermissions($request->permissions);

            return redirect()->route('org-roles.index')->with(['success' => __('message.created_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function show($id)
    {
        try {
            $role = Role::find($id);
            return view('organization.users.roles.show', compact('role'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function edit($id)
    {
        try {
            $role = Role::find($id);
            return view('organization.users.roles.edit', compact('role'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function update(AdminRoleRequest $request, $id)
    {
        try {
            $role = Role::find($id);
            if ($role->is_super == 1)
                return redirect()->back()->with(['error' => __('message.error_admin_role_update')]);
            $request_data = $request->except(['_token', 'permissions']);
            $request_data['created_by'] = auth('admin')->user()->email;
            //update role
            $role->update($request_data);
            $role->syncPermissions($request->permissions); //update role permassion
            return redirect()->route('org-roles.index')->with(['success' => __('message.updated_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function destroy($id)
    {
        try {
            $role = Role::find($id);
            if ($role->is_super == 1)
                return redirect()->back()->with(['error' => __('message.error_admin_role_delete')]);

            $role->delete();
            return redirect()->route('org-roles.index')->with(['success' => __('message.deleted_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }
}
