<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrganizationUserCreationRequest;
use App\Http\Requests\OrganizationUserRequest;
use App\Models\OrganizationUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\Collection;

class OrgUsersController extends Controller
{
    private $organizationUser;

    public function __construct(OrganizationUser $organizationUser)

    {
        $this->middleware(['HasOrgUser:read'])->only(['index', 'show']);
        $this->middleware(['HasOrgUser:update'])->only('edit');
        $this->middleware(['HasOrgUser:create'])->only('create');
        $this->middleware(['HasOrgUser:delete'])->only('destroy');
        $this->middleware(['HasOrgBranchUser:read'])->only(['getBranchUsers', 'showBranchUser']);
        $this->middleware(['HasOrgBranchUser:update'])->only('editBranchUser');
        $this->middleware(['HasOrgBranchUser:delete'])->only('deleteBranchUser');

        $this->organizationUser = $organizationUser;
    }

    public function index()
    {
        try {
            $record = getModelData();
            $users = $record->organization_users;
            return view('organization.users.orgUsers.index', compact('users', 'record'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function create()
    {
        try {
            $record = getModelData();
            $roles = $record->roles()->latest('id')->get();
            return view('organization.users.orgUsers.create', compact('record', 'roles'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function store(OrganizationUserCreationRequest $request)
    {
        try {
            $record = getModelData();
            if (!$request->has('active'))
                $request->request->add(['active' => 0]);
            else
                $request->request->add(['active' => 1]);

            $request_data = $request->except(['_token', 'password_confirmation']);
            $request_data['created_by'] = auth('web')->user()->email;
            $user = $record->organization_users()->create($request_data);
            $user->attachRole($request->role_id);
            return redirect()->route('organization.users.index')->with(['success' => __('message.created_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function show($id)
    {
        try {
            $record = getModelData();
            $user = $record->organization_users()->find($id);
            return view('organization.users.orgUsers.show', compact('user', 'record'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function edit($id)
    {
        try {
            $record = getModelData();
            $user = $record->organization_users()->find($id);
            $roles = $record->roles()->latest('id')->get();
            return view('organization.users.orgUsers.edit', compact('user', 'record', 'roles'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function update(OrganizationUserCreationRequest $request, $id)
    {
        try {
            $record = getModelData();
            $user = $record->organization_users()->find($id);

            if (!$request->has('active'))
                $request->request->add(['active' => 0]);
            else
                $request->request->add(['active' => 1]);

            $request_data = $request->except(['_token', 'password', 'password_confirmation']);
            $request_data['created_by'] = auth('web')->user()->email;
            if ($request->has('password')) {
                $request_data['password'] = $request->password;
            }
            $user->update($request_data);
            $user->syncRoles([$request->role_id]);

            return redirect()->route('organization.users.index')->with(['success' => __('message.updated_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function destroy($id)
    {
        try {
            $record = getModelData();
            $org_user = $record->organization_users()->find($id);
            $user = auth::guard('web')->id();
            if ($user == $org_user->id) {
                return redirect()->back()->with('error', __('message.active_session'));
            }
            $org_user->delete();
            return redirect()->route('organization.users.index')->with(['success' => __('message.deleted_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }

    }

    public function getBranchUsers()
    {
        try {
            $record = getModelData();
            $branches = $record->branches;
            $data = [];
            foreach ($branches as $branch) {
                $users = $branch->organization_users;
                foreach ($users as $user) {
                    $data[] = [
                        'id' => $user->id,
                        'user_name' => $user->user_name,
                        'email' => $user->email,
                        'role' => $user->roles()->first() ? $user->roles()->first()->name : '--',
                        'active' => $user->getActive(),
                        'created_by' => $user->created_by,
                        'branch' => $user->organizable->name,
                        'created_at' => $user->created_at,
                        'updated_at' => $user->updated_at,
                        'organizable_type' => $user->organizable_type,
                        'organizable_id' => $user->organizable_id,
                    ];
                }
            }
            return view('organization.users.branchUsers.index', compact('data', 'record'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function showBranchUser($id)
    {
        try {
            $record = getModelData();
            $user = $this->organizationUser->find($id);
            return view('organization.users.branchUsers.show', compact('user', 'record'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function editBranchUser($id)
    {
        try {
            $record = getModelData();
            $user = $this->organizationUser->find($id);
            $model = new $user->organizable_type;
            $branch = $model->find($user->organizable_id);
            $roles = $branch->roles()->latest('id')->get();
            return view('organization.users.branchUsers.edit', compact('user', 'record','roles'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function updateBranchUser(OrganizationUserCreationRequest $request, $id)
    {
        try {
            $user = $this->organizationUser->find($id);

            if (!$request->has('active'))
                $request->request->add(['active' => 0]);
            else
                $request->request->add(['active' => 1]);

            $request_data = $request->except(['_token', 'password', 'password_confirmation']);
            $request_data['created_by'] = auth('web')->user()->email;
            if ($request->has('password')) {
                $request_data['password'] = $request->password;
            }
            $user->update($request_data);
            $user->syncRoles([$request->role_id]);
            return redirect()->route('organization.org-branches-users.index')->with(['success' => __('message.updated_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function deleteBranchUser(Request $request, $id)
    {
        try {
            $class = $request->organizable_type;
            $model = new $class;
            $branch = $model->find($request->organizable_id);
            $users = $branch->organization_users;
            if (count($users) < 2)
                return redirect()->route('organization.users.org-branches-users.index')->with(['error' => __('message.branch_user_deletion_error')]);

            $user = $branch->organization_users()->find($id);
            $user->delete();
            return redirect()->route('organization.org-branches-users.index')->with(['success' => __('message.deleted_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }

    }

}
