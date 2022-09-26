<?php

namespace App\Http\Controllers\Dashboard\Organizations;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminCarShowroomRequest;
use App\Http\Requests\Admin\AdminCarWashRequest;
use App\Http\Requests\Admin\AdminTechnicalInspectionCenterRequest;
use App\Models\CarWash;
use App\Models\City;
use App\Models\TechnicalInspectionCenter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CarWashController extends Controller
{
    private $model;
    private $city;

    public function __construct(CarWash $model, City $city)
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
            $car_washes = $this->model->latest('id')->get();
            return view('admin.organizations.auto_service_centers.car_washes.index', compact('car_washes'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function create()
    {
        try {
            $cities = $this->city->latest('id')->get();
            return view('admin.organizations.auto_service_centers.car_washes.create', compact('cities'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function store(AdminCarWashRequest $request)
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

            $car_wash = $this->model->create($request_data);

            $car_wash->organization_users()->create([
                'user_name' => $request->user_name,
                'email' => $request->email,
                'password' => $request->password,
            ]);
            return redirect()->route('car-washes.index')->with(['success' => __('message.created_successfully')]);
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
            $car_wash = $this->getModelById($id);
            $users = $car_wash->organization_users()->get();
            return view('admin.organizations.auto_service_centers.car_washes.show', compact('car_wash', 'users'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function edit($id)
    {
        try {
            $car_wash = $this->getModelById($id);
            $users = $car_wash->organization_users()->get();
            $cities = $this->city->latest('id')->get();
            return view('admin.organizations.auto_service_centers.car_washes.edit', compact('car_wash', 'users', 'cities'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function update(AdminCarWashRequest $request, $id)
    {
        try {
            $car_wash = $this->getModelById($id);

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

                if (File::exists($image_path . $car_wash->getRawOriginal('logo'))) {
                    File::delete($image_path . $car_wash->getRawOriginal('logo'));
                }

                $image = $request->logo->store('logos');
                $request_data['logo'] = $image;
            }

            $user = $car_wash->organization_users()->find($request->organization_user_id);
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

            $car_wash->update($request_data);

            return redirect()->route('car-washes.index')->with(['success' => __('message.updated_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function destroy($id)
    {
        try {
            $car_wash = $this->getModelById($id);

            $image_path = public_path('uploads/');
            if (File::exists($image_path . $car_wash->getRawOriginal('logo'))) {
                File::delete($image_path . $car_wash->getRawOriginal('logo'));
            }
            $car_wash->delete();
            return redirect()->route('car-washes.index')->with(['success' => __('message.deleted_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function getUser($org_id, $user_id)
    {
        try {
            $car_wash = $this->model->find($org_id);
            $user = $car_wash->organization_users()->find($user_id);

            $data = compact('user');
            return response()->json(['status' => true, 'data' => $data]);
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function getUsers($org_id)
    {
        try {
            $car_wash = $this->model->find($org_id);
            $users = $car_wash->organization_users()->latest('id')->get();

            $data = compact('users');
            return response()->json(['status' => true, 'data' => $data]);
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }
}
