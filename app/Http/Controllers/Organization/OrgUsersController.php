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

    public function index()
    {
        $user = auth()->guard('web')->user();
        $model_type = $user->organizable_type;
        $model_id = $user->organizable_id;
        $model = new $model_type;
        $record = $model->find($model_id);

        $org_users = $record->organization_users;

        return view('organization.users.index', compact('org_users', 'record'));
    }


//    public function create()
//    {
//        //
//    }


    public function store(OrganizationUserCreationRequest $request)
    {
        try {
            $user = auth()->guard('web')->user();
            $model_type = $user->organizable_type;
            $model_id = $user->organizable_id;
            $model = new $model_type;
            $record = $model->find($model_id);
            if (!$request->has('active'))
                $request->request->add(['active' => 0]);
            else
                $request->request->add(['active' => 1]);

            $request_data = $request->except(['_token']);

            $record->organization_users()->create($request_data);

            return redirect()->route('organization.users.index')->with(['success' => __('message.created_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }


    public function show($id)
    {
        $show_org_user = OrganizationUser::find($id);

        $data = compact('show_org_user');
        return response()->json(['status' => true, 'data' => $data]);
    }

    public function edit($id)
    {
        //
    }


    public function update(OrganizationUserCreationRequest $request, $id)
    {

        try {
            $show_org_user = OrganizationUser::find($id);
            if (!$request->has('active'))
                $request->request->add(['active' => 0]);
            else
                $request->request->add(['active' => 1]);

            $request_data = $request->except(['_token', 'password', 'password_confirmation']);

            if ($request->has('password')) {
                $request_data['password'] = $request->password;
            }
            $show_org_user->update($request_data);

            return redirect()->route('organization.users.index')->with(['success' => __('message.updated_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }


    public function destroy($id)
    {
        try {
            $org_user = OrganizationUser::find($id);
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

}
