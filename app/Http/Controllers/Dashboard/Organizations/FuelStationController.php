<?php

namespace App\Http\Controllers\Dashboard\Organizations;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminFuelStationRequest;
use App\Models\Area;
use App\Models\City;
use App\Models\Country;
use App\Models\FuelStation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class FuelStationController extends Controller
{
    private $model;
    private $country;
    private $city;
    private $area;

    public function __construct(FuelStation $model, Country $country, City $city, Area $area)
    {
        $this->middleware(['permission:read-fuel_stations'])->only('index');
        $this->middleware(['permission:create-fuel_stations'])->only('create');
        $this->middleware(['permission:update-fuel_stations'])->only('edit');
        $this->middleware(['permission:delete-fuel_stations'])->only('delete');

        $this->model = $model;
        $this->country = $country;
        $this->city = $city;
        $this->area = $area;
    }

    public function index()
    {
        try {
            $fuel_stations = $this->model->latest('id')->get();
            return view('admin.organizations.fuel_stations.index', compact('fuel_stations'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }


    public function create()
    {
        try {
            $countries = $this->country->latest('id')->get();
            return view('admin.organizations.fuel_stations.create', compact('countries'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function store(AdminFuelStationRequest $request)
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

            $request_data = $request->except(['_token', 'logo', 'fuel_types', 'user_name', 'email', 'password', 'password_confirmation']);
            $request_data['created_by'] = auth('admin')->user()->email;
            if ($request->has('logo')) {
                $image = $request->logo->store('logos');
                $request_data['logo'] = $image;
            }

            if ($request->has('fuel_types')) {
                $request_data['fuel_types'] = implode(",", $request->fuel_types);;
            }

            $fuel_station = $this->model->create($request_data);


            $fuel_station->organization_users()->create([
                'user_name' => $request->user_name,
                'email' => $request->email,
                'password' => $request->password,
            ]);
            return redirect()->route('fuel-stations.index')->with(['success' => __('message.created_successfully')]);

        } catch
        (\Exception $e) {
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
            $fuel_station = $this->getModelById($id);
            $users = $fuel_station->organization_users()->get();
            return view('admin.organizations.fuel_stations.show', compact('fuel_station', 'users'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function edit($id)
    {
        try {
            $fuel_station = $this->getModelById($id);
            $users = $fuel_station->organization_users()->get();
            $countries = $this->country->latest('id')->get();
            $cities = $this->city->latest('id')->get();
            $areas = $this->area->latest('id')->get();
            return view('admin.organizations.fuel_stations.edit', compact('fuel_station', 'users', 'countries', 'cities', 'areas'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }


    public function update(AdminFuelStationRequest $request, $id)
    {
        try {
            $fuel_station = $this->getModelById($id);
            if (!$request->has('active'))
                $request->request->add(['active' => 0]);
            else
                $request->request->add(['active' => 1]);

            if (!$request->has('active_number_of_views'))
                $request->request->add(['active_number_of_views' => 0]);
            else
                $request->request->add(['active_number_of_views' => 1]);

            $request_data = $request->except(['_token', 'logo', 'user_name', 'password', 'password_confirmation', 'organization_user_id', 'fuel_types']);
            $request_data['created_by'] = auth('admin')->user()->email;
            if ($request->has('logo')) {
                $image_path = public_path('uploads/');

                if (File::exists($image_path . $fuel_station->getRawOriginal('logo'))) {
                    File::delete($image_path . $fuel_station->getRawOriginal('logo'));
                }

                $image = $request->logo->store('logos');
                $request_data['logo'] = $image;
            }

            if ($request->has('fuel_types')) {
                $request_data['fuel_types'] = implode(",", $request->fuel_types);;
            }

            $user = $fuel_station->organization_users()->find($request->organization_user_id);
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

            $fuel_station->update($request_data);

            return redirect()->route('fuel-stations.index')->with(['success' => __('message.updated_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        try {
            $fuel_station = $this->getModelById($id);

            $image_path = public_path('uploads/');
            if (File::exists($image_path . $fuel_station->getRawOriginal('logo'))) {
                File::delete($image_path . $fuel_station->getRawOriginal('logo'));
            }
            $fuel_station->delete();
            return redirect()->route('fuel-stations.index')->with(['success' => __('message.deleted_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function getUser($org_id, $user_id)
    {
        try {
            $wench = $this->model->find($org_id);
            $user = $wench->organization_users()->find($user_id);

            $data = compact('user');
            return response()->json(['status' => true, 'data' => $data]);
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function getUsers($org_id)
    {
        try {
            $wench = $this->model->find($org_id);
            $users = $wench->organization_users()->latest('id')->get();

            $data = compact('users');
            return response()->json(['status' => true, 'data' => $data]);
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }
}
