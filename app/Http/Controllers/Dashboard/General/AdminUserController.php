<?php

namespace App\Http\Controllers\Dashboard\General;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminRequest;
use App\Models\Admin;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;

class AdminUserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:read-admins'])->only('index');
        $this->middleware(['permission:create-admins'])->only('create');
        $this->middleware(['permission:update-admins'])->only('edit');
        $this->middleware(['permission:delete-admins'])->only('delete');
    }

    public function index()
    {
        try {
            $users = Admin::latest('id')->get();
            return view('admin.general.adminUsers.index', compact('users'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function show($id)
    {
        try {
            $user = Admin::find($id);
            return view('admin.general.adminUsers.show', compact('user'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function create()
    {
        try {
            $roles = Role::latest('id')->get();
            return view('admin.general.adminUsers.create', compact('roles'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }


    public function store(AdminRequest $request)
    {
        try {
            if (!$request->has('active'))
                $request->request->add(['active' => 0]);
            $request_data = $request->except(['_token']);
            $request_data['created_by'] = auth('admin')->user()->email;
            $admin = Admin::create($request_data);
            $admin->attachRole($request->role_id);
            return redirect()->route('admin-users.index')->with(['success' => __('message.created_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }


    public function edit($id)
    {
        try {
            $roles = Role::latest('id')->get();
            $user = Admin::find($id);
            return view('admin.general.adminUsers.edit', compact('user', 'roles'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }


    public function update(AdminRequest $request, $id)
    {
        try {
            $show_user = Admin::find($id);
            if (!$request->has('active'))
                $request->request->add(['active' => 0]);
            else
                $request->request->add(['active' => 1]);

            $request_data = $request->except(['_token', 'password', 'password_confirmation']);
            $request_data['created_by'] = auth('admin')->user()->email;
            if ($request->has('password')) {
                $request_data['password'] = $request->password;
            }
            $show_user->update($request_data);
            $show_user->syncRoles([$request->role_id]);
            return redirect()->route('admin-users.index')->with(['success' => __('message.updated_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong') . $e->getMessage()]);
        }
    }


    public function destroy($id)
    {
        try {
            $admin_user = Admin::find($id);
            $user = auth::guard('admin')->id();
            if ($user == $admin_user->id) {
                return redirect()->back()->with('error', __('message.active_session'));
            }
            $admin_user->delete();
            return redirect()->route('admin-users.index')->with(['success' => __('message.deleted_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }

    }

}
