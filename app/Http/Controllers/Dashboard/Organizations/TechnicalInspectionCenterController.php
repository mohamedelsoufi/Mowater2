<?php

namespace App\Http\Controllers\Dashboard\Organizations;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminTechnicalInspectionCenterRequest;
use App\Models\City;
use App\Models\TechnicalInspectionCenter;
use Illuminate\Support\Facades\File;

class TechnicalInspectionCenterController extends Controller
{
    private $model;
    private $city;

    public function __construct(TechnicalInspectionCenter $model, City $city)
    {
        $this->middleware(['permission:read-technical_inspection_centers'])->only('index');
        $this->middleware(['permission:create-technical_inspection_centers'])->only('create');
        $this->middleware(['permission:update-technical_inspection_centers'])->only('edit');
        $this->middleware(['permission:delete-technical_inspection_centers'])->only('delete');

        $this->model = $model;
        $this->city = $city;
    }

    public function index()
    {
        try {
            $centers = $this->model->latest('id')->get();
            return view('admin.organizations.auto_service_centers.technical_inspection_centers.index', compact('centers'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function create()
    {
        try {
            $cities = $this->city->latest('id')->get();
            return view('admin.organizations.auto_service_centers.technical_inspection_centers.create', compact('cities'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function store(AdminTechnicalInspectionCenterRequest $request)
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

            if (!$request->has('reservation_active'))
                $request->request->add(['reservation_active' => 0]);
            else
                $request->request->add(['reservation_active' => 1]);

            $request_data = $request->except(['_token', 'logo', 'user_name', 'email', 'password', 'password_confirmation']);
            $request_data['created_by'] = auth('admin')->user()->email;
            if ($request->has('logo')) {
                $image = $request->logo->store('logos');
                $request_data['logo'] = $image;
            }

            $center = $this->model->create($request_data);

            createMasterOrgUser($center);
            return redirect()->route('inspection-centers.index')->with(['success' => __('message.created_successfully')]);
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
            $center = $this->getModelById($id);
            $users = $center->organization_users()->get();
            return view('admin.organizations.auto_service_centers.technical_inspection_centers.show', compact('center', 'users'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function edit($id)
    {
        try {
            $center = $this->getModelById($id);
            $users = $center->organization_users()->get();
            $cities = $this->city->latest('id')->get();
            return view('admin.organizations.auto_service_centers.technical_inspection_centers.edit', compact('center', 'users', 'cities'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function update(AdminTechnicalInspectionCenterRequest $request, $id)
    {
        try {
            $center = $this->getModelById($id);

            if (!$request->has('active'))
                $request->request->add(['active' => 0]);
            else
                $request->request->add(['active' => 1]);

            if (!$request->has('active_number_of_views'))
                $request->request->add(['active_number_of_views' => 0]);
            else
                $request->request->add(['active_number_of_views' => 1]);

            if (!$request->has('reservation_active'))
                $request->request->add(['reservation_active' => 0]);
            else
                $request->request->add(['reservation_active' => 1]);

            $request_data = $request->except(['_token', 'logo', 'user_name', 'password', 'password_confirmation', 'organization_user_id']);
            $request_data['created_by'] = auth('admin')->user()->email;
            if ($request->has('logo')) {
                $image_path = public_path('uploads/');

                if (File::exists($image_path . $center->getRawOriginal('logo'))) {
                    File::delete($image_path . $center->getRawOriginal('logo'));
                }

                $image = $request->logo->store('logos');
                $request_data['logo'] = $image;
            }

            $user = $center->organization_users()->find($request->organization_user_id);
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

            $center->update($request_data);

            return redirect()->route('inspection-centers.index')->with(['success' => __('message.updated_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function destroy($id)
    {
        try {
            $center = $this->getModelById($id);

            $image_path = public_path('uploads/');
            if (File::exists($image_path . $center->getRawOriginal('logo'))) {
                File::delete($image_path . $center->getRawOriginal('logo'));
            }
            $center->delete();
            return redirect()->route('inspection-centers.index')->with(['success' => __('message.deleted_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function getUser($org_id, $user_id)
    {
        try {
            $car_showroom = $this->model->find($org_id);
            $user = $car_showroom->organization_users()->find($user_id);

            $data = compact('user');
            return response()->json(['status' => true, 'data' => $data]);
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function getUsers($org_id)
    {
        try {
            $car_showroom = $this->model->find($org_id);
            $users = $car_showroom->organization_users()->latest('id')->get();

            $data = compact('users');
            return response()->json(['status' => true, 'data' => $data]);
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }
}
