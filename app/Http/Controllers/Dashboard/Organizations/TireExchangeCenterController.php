<?php

namespace App\Http\Controllers\Dashboard\Organizations;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminTireExchangeCenterRequest;
use App\Models\City;
use App\Models\TireExchangeCenter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class TireExchangeCenterController extends Controller
{
    private $model;
    private $city;

    public function __construct(TireExchangeCenter $model, City $city)
    {
        $this->middleware(['permission:read-tire_exchange_centers'])->only('index');
        $this->middleware(['permission:create-tire_exchange_centers'])->only('create');
        $this->middleware(['permission:update-tire_exchange_centers'])->only('edit');
        $this->middleware(['permission:delete-tire_exchange_centers'])->only('delete');

        $this->model = $model;
        $this->city = $city;
    }

    public function index()
    {
        try {
            $centers = $this->model->latest('id')->get();
            return view('admin.organizations.auto_service_centers.tire_exchange_centers.index', compact('centers'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function create()
    {
        try {
            $cities = $this->city->latest('id')->get();
            return view('admin.organizations.auto_service_centers.tire_exchange_centers.create', compact('cities'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function store(AdminTireExchangeCenterRequest $request)
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

            $center = $this->model->create($request_data);

            $center->organization_users()->create([
                'user_name' => $request->user_name,
                'email' => $request->email,
                'password' => $request->password,
            ]);
            return redirect()->route('tire-exchange-centers.index')->with(['success' => __('message.created_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' =>  __('message.something_wrong')]);
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
            return view('admin.organizations.auto_service_centers.tire_exchange_centers.show', compact('center', 'users'));
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
            return view('admin.organizations.auto_service_centers.tire_exchange_centers.edit', compact('center', 'users', 'cities'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function update(AdminTireExchangeCenterRequest $request, $id)
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

            $request_data = $request->except(['_token', 'logo', 'user_name', 'password', 'password_confirmation', 'organization_user_id']);

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

            return redirect()->route('tire-exchange-centers.index')->with(['success' => __('message.updated_successfully')]);
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
            return redirect()->route('tire-exchange-centers.index')->with(['success' => __('message.deleted_successfully')]);
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
