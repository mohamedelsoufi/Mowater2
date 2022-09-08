<?php

namespace App\Http\Controllers\Dashboard\Organizations;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminCarShowroomRequest;
use App\Models\Area;
use App\Models\CarShowroom;
use App\Models\City;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CarShowroomController extends Controller
{
    private $model;
    private $country;
    private $city;
    private $area;

    public function __construct(CarShowroom $model, Country $country, City $city, Area $area)
    {
        $this->middleware(['permission:read-car_showrooms'])->only('index');
        $this->middleware(['permission:create-car_showrooms'])->only('create');
        $this->middleware(['permission:update-car_showrooms'])->only('edit');
        $this->middleware(['permission:delete-car_showrooms'])->only('delete');

        $this->model = $model;
        $this->country = $country;
        $this->city = $city;
        $this->area = $area;
    }

    public function index()
    {
        try {
            $car_showrooms = $this->model->latest('id')->get();
            return view('admin.organizations.car_showrooms.index', compact('car_showrooms'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function create()
    {
        try {
            $countries = $this->country->latest('id')->get();
            return view('admin.organizations.car_showrooms.create', compact('countries'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function store(AdminCarShowroomRequest $request)
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

            if (!$request->has('delivery_active'))
                $request->request->add(['delivery_active' => 0]);
            else
                $request->request->add(['delivery_active' => 1]);

            $request_data = $request->except(['_token', 'logo', 'user_name', 'email', 'password', 'password_confirmation']);

            if ($request->has('logo')) {
                $image = $request->logo->store('logos');
                $request_data['logo'] = $image;
            }

            $car_showroom = $this->model->create($request_data);

            $car_showroom->organization_users()->create([
                'user_name' => $request->user_name,
                'email' => $request->email,
                'password' => $request->password,
            ]);
            return redirect()->route('car-showrooms.index')->with(['success' => __('message.created_successfully')]);
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
            $car_showroom = $this->getModelById($id);
            $users = $car_showroom->organization_users()->latest('id')->get();
            return view('admin.organizations.car_showrooms.show', compact('car_showroom', 'users'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function edit($id)
    {
        try {
            $car_showroom = $this->getModelById($id);
            $users = $car_showroom->organization_users()->get();
            $countries = $this->country->latest('id')->get();
            $cities = $this->city->latest('id')->get();
            $areas = $this->area->latest('id')->get();
            return view('admin.organizations.car_showrooms.edit', compact('car_showroom', 'users', 'countries', 'cities', 'areas'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function update(AdminCarShowroomRequest $request, $id)
    {
        try {
            $car_showroom = $this->getModelById($id);
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

            if (!$request->has('delivery_active'))
                $request->request->add(['delivery_active' => 0]);
            else
                $request->request->add(['delivery_active' => 1]);

            $request_data = $request->except(['_token', 'logo', 'user_name', 'password', 'password_confirmation','organization_user_id']);

            if ($request->has('logo')) {
                $image_path = public_path('uploads/');

                if (File::exists($image_path . $car_showroom->getRawOriginal('logo'))) {
                    File::delete($image_path . $car_showroom->getRawOriginal('logo'));
                }

                $image = $request->logo->store('logos');
                $request_data['logo'] = $image;
            }

            $user = $car_showroom->organization_users()->find($request->organization_user_id);
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
            $car_showroom->update($request_data);
            return redirect()->route('car-showrooms.index')->with(['success' => __('message.updated_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        try {
            $car_showroom = $this->getModelById($id);
            $image_path = public_path('uploads/');
            if (File::exists($image_path . $car_showroom->getRawOriginal('logo'))) {
                File::delete($image_path . $car_showroom->getRawOriginal('logo'));
            }
            $car_showroom->delete();
            return redirect()->route('car-showrooms.index')->with(['success' => __('message.deleted_successfully')]);
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
