<?php

namespace App\Http\Controllers\Dashboard\General;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminOrganizationUserRequest;
use App\Models\OrganizationUser;
use App\Models\Section;
use Illuminate\Http\Request;

class OrganizationUserController extends Controller
{
    private $model;
    private $org;

    public function __construct(OrganizationUser $model, Section $org)
    {
        $this->middleware(['permission:read-org_users'])->only('index');
        $this->middleware(['permission:create-org_users'])->only('create');
        $this->middleware(['permission:update-org_users'])->only('edit');
        $this->middleware(['permission:delete-org_users'])->only('delete');

        $this->model = $model;
        $this->org = $org;
    }

    public function index()
    {
        try {
            $users = $this->model->latest('id')->get();
            return view('admin.general.OrgUsers.index', compact('users'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

//    public function create()
//    {
//        //
//    }
//
//    public function store(Request $request)
//    {
//        //
//    }

    private function getModelById($id)
    {
        $model = $this->model->find($id);
        return $model;
    }

    public function show($id)
    {
        try {
            $user = $this->getModelById($id);
            return view('admin.general.OrgUsers.show', compact('user'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function edit($id)
    {
        try {
            $user = $this->getModelById($id);
            return view('admin.general.OrgUsers.edit', compact('user'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function update(AdminOrganizationUserRequest $request, $id)
    {
        try {
            $user = $this->getModelById($id);

            if (!$request->has('active'))
                $request->request->add(['active' => 0]);
            else
                $request->request->add(['active' => 1]);

            $request_data = $request->except(['_token','password_confirmation']);
            $request_data['created_by'] = auth()->user()->email;
            $user->update($request_data);
            return redirect()->route('org-users.index')->with(['success' => __('message.updated_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function destroy($id)
    {
        try {
            $user = $this->getModelById($id);
            $user->delete();
            return redirect()->route('org-users.index')->with(['success' => __('message.deleted_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }
}
