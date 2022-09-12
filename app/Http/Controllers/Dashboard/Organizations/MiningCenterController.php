<?php

namespace App\Http\Controllers\Dashboard\Organizations;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminMiningCenterRequest;
use App\Models\City;
use App\Models\MiningCenter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class MiningCenterController extends Controller
{
    private $model;
    private $city;

    public function __construct(MiningCenter $model, City $city)
    {
        $this->middleware(['permission:read-mining_centers'])->only('index');
        $this->middleware(['permission:create-mining_centers'])->only('create');
        $this->middleware(['permission:update-mining_centers'])->only('edit');
        $this->middleware(['permission:delete-mining_centers'])->only('delete');

        $this->model = $model;
        $this->city = $city;
    }

    public function index()
    {
        try {
            $mining_centers = $this->model->latest('id')->get();
            return view('admin.organizations.auto_service_centers.mining_centers.index', compact('mining_centers'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function create()
    {
        try {
            $cities = $this->city->latest('id')->get();
            return view('admin.organizations.auto_service_centers.mining_centers.create', compact('cities'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function store(AdminMiningCenterRequest $request)
    {
        try {
            if (!$request->has('active'))
                $request->request->add(['active' => 0]);
            else
                $request->request->add(['active' => 1]);

            if (!$request->has('active_number_of_views'))
                $request->request->add(['active_number_of_views' => 0]);
            else
                $request->request->add(['active_number_of_views' => 1]);

            $request_data = $request->except(['_token', 'logo', 'user_name', 'email', 'password', 'password_confirmation']);

            if ($request->has('logo')) {
                $image = $request->logo->store('logos');
                $request_data['logo'] = $image;
            }

            $mining_center = $this->model->create($request_data);

            $mining_center->organization_users()->create([
                'user_name' => $request->user_name,
                'email' => $request->email,
                'password' => $request->password,
            ]);
            return redirect()->route('mining-centers.index')->with(['success' => __('message.created_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    private function getModelById($id)
    {
        $model = $this->model->find($id);
        return $model;
    }

    public function show($id)
    {
        try {
            $mining_center = $this->getModelById($id);
            $users = $mining_center->organization_users()->get();
            return view('admin.organizations.auto_service_centers.mining_centers.show', compact('mining_center', 'users'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function edit($id)
    {
        try {
            $mining_center = $this->getModelById($id);
            $users = $mining_center->organization_users()->get();
            $cities = $this->city->latest('id')->get();
            return view('admin.organizations.auto_service_centers.mining_centers.edit', compact('mining_center', 'users', 'cities'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function update(AdminMiningCenterRequest $request, $id)
    {
        try {
            $mining_center = $this->getModelById($id);

            if (!$request->has('active'))
                $request->request->add(['active' => 0]);
            else
                $request->request->add(['active' => 1]);

            if (!$request->has('active_number_of_views'))
                $request->request->add(['active_number_of_views' => 0]);
            else
                $request->request->add(['active_number_of_views' => 1]);

            $request_data = $request->except(['_token', 'logo', 'user_name', 'password', 'password_confirmation', 'organization_user_id']);

            if ($request->has('logo')) {
                $image_path = public_path('uploads/');

                if (File::exists($image_path . $mining_center->getRawOriginal('logo'))) {
                    File::delete($image_path . $mining_center->getRawOriginal('logo'));
                }

                $image = $request->logo->store('logos');
                $request_data['logo'] = $image;
            }

            $user = $mining_center->organization_users()->find($request->organization_user_id);
            if ($request->user_name) {

                $user->update([
                    'user_name' => $request->user_name,
                ]);
            }
            if ($request->password) {

                $user->update([
                    'password' => $request->password,
                ]);
            }

            $mining_center->update($request_data);

            return redirect()->route('mining-centers.index')->with(['success' => __('message.updated_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function destroy($id)
    {
        try {
            $mining_center = $this->getModelById($id);

            $image_path = public_path('uploads/');
            if (File::exists($image_path . $mining_center->getRawOriginal('logo'))) {
                File::delete($image_path . $mining_center->getRawOriginal('logo'));
            }
            $mining_center->delete();
            return redirect()->route('mining-centers.index')->with(['success' => __('message.deleted_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function getUser($org_id, $user_id)
    {
        try {
            $mining_center = $this->model->find($org_id);
            $user = $mining_center->organization_users()->find($user_id);

            $data = compact('user');
            return response()->json(['status' => true, 'data' => $data]);
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function getUsers($org_id)
    {
        try {
            $mining_center = $this->model->find($org_id);
            $users = $mining_center->organization_users()->latest('id')->get();

            $data = compact('users');
            return response()->json(['status' => true, 'data' => $data]);
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }
}
