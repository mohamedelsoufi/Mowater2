<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminRoleRequest;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrgRolesController extends Controller
{
    private $role;

    public function __construct(Role $role)
    {
        $this->middleware(['HasOrgRoles:read'])->only(['index', 'show']);
        $this->middleware(['HasOrgRoles:update'])->only('edit');
        $this->middleware(['HasOrgRoles:create'])->only('create');
        $this->middleware(['HasOrgRoles:delete'])->only('destroy');
        $this->role = $role;
    }

    public function index()
    {
        try {
            $record = getModelData();
            $roles = $record->roles()->latest('id')->get();
            return view('organization.users.roles.index', compact('roles', 'record'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function create()
    {
        $record = getModelData();
        return view('organization.users.roles.create',compact('record'));
    }

    public function store(AdminRoleRequest $request)
    {
        try {
            $record = getModelData();
            //create role
            $request_data = $request->except(['_token', 'permissions']);
            $request_data['created_by'] = auth('web')->user()->email;
//            return $request->permissions;
            $role = $record->roles()->create($request_data);
            $role->attachPermissions($request->permissions);

            return redirect()->route('organization.org-roles.index')->with(['success' => __('message.created_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function show($id)
    {
        try {
            $record = getModelData();
            $role = $record->roles()->find($id);
            return view('organization.users.roles.show', compact('role', 'record'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function edit($id)
    {
        try {
            $record = getModelData();
            $role = $record->roles()->find($id);
            return view('organization.users.roles.edit', compact('role','record'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function update(AdminRoleRequest $request, $id)
    {
        try {
            $record = getModelData();
            $role = $record->roles()->find($id);
            if ($role->is_super == 1)
                return redirect()->back()->with(['error' => __('message.error_admin_role_update')]);
            $request_data = $request->except(['_token', 'permissions']);
            $request_data['created_by'] = auth('web')->user()->email;
            //update role
            $role->update($request_data);
            $role->syncPermissions($request->permissions); //update role permassion
            return redirect()->route('organization.org-roles.index')->with(['success' => __('message.updated_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        try {
            $record = getModelData();
            $role = $record->roles()->find($id);
            if ($role->is_super == 1)
                return redirect()->back()->with(['error' => __('message.error_admin_role_delete')]);

            $role->delete();
            return redirect()->route('organization.org-roles.index')->with(['success' => __('message.deleted_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }
}
