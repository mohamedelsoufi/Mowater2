<?php

namespace App\Http\Controllers\Dashboard\Organizations;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminTrafficClearingOfficeRequest;
use App\Models\Area;
use App\Models\City;
use App\Models\Country;
use App\Models\TrafficClearingOffice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class TrafficClearingOfficeController extends Controller
{
    private $model;
    private $country;
    private $city;
    private $area;

    public function __construct(TrafficClearingOffice $model, Country $country, City $city, Area $area)
    {
        $this->middleware(['permission:read-traffic_clearing_offices'])->only('index');
        $this->middleware(['permission:create-traffic_clearing_offices'])->only('create');
        $this->middleware(['permission:update-traffic_clearing_offices'])->only('edit');
        $this->middleware(['permission:delete-traffic_clearing_offices'])->only('delete');

        $this->model = $model;
        $this->country = $country;
        $this->city = $city;
        $this->area = $area;
    }

    public function index()
    {
        try {
            $offices = $this->model->latest('id')->get();
            return view('admin.organizations.traffic_clearing_offices.index', compact('offices'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function create()
    {
        try {
            $countries = $this->country->latest('id')->get();
            return view('admin.organizations.traffic_clearing_offices.create', compact('countries'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function store(AdminTrafficClearingOfficeRequest $request)
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

            $office = $this->model->create($request_data);

            $office->organization_users()->create([
                'user_name' => $request->user_name,
                'email' => $request->email,
                'password' => $request->password,
            ]);
            return redirect()->route('traffic-clearing-offices.index')->with(['success' => __('message.created_successfully')]);
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
            $office = $this->getModelById($id);
            $users = $office->organization_users()->latest('id')->get();
            return view('admin.organizations.traffic_clearing_offices.show', compact('office', 'users'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function edit($id)
    {
        try {
            $office = $this->getModelById($id);
            $users = $office->organization_users()->get();
            $countries = $this->country->latest('id')->get();
            $cities = $this->city->latest('id')->get();
            $areas = $this->area->latest('id')->get();
            return view('admin.organizations.traffic_clearing_offices.edit', compact('office', 'users', 'countries', 'cities', 'areas'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function update(AdminTrafficClearingOfficeRequest $request, $id)
    {
        try {
            $office = $this->getModelById($id);
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

                if (File::exists($image_path . $office->getRawOriginal('logo'))) {
                    File::delete($image_path . $office->getRawOriginal('logo'));
                }

                $image = $request->logo->store('logos');
                $request_data['logo'] = $image;
            }

            $user = $office->organization_users()->find($request->organization_user_id);
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

            $office->update($request_data);

            return redirect()->route('traffic-clearing-offices.index')->with(['success' => __('message.updated_successfully')]);

        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function destroy($id)
    {
        try {
            $office = $this->getModelById($id);

            $image_path = public_path('uploads/');
            if (File::exists($image_path . $office->getRawOriginal('logo'))) {
                File::delete($image_path . $office->getRawOriginal('logo'));
            }
            $user = $office->organization_users();
            $user->delete();
            $office->delete();
            return redirect()->route('traffic-clearing-offices.index')->with(['success' => __('message.deleted_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function getUser($org_id, $user_id)
    {
        try {
            $agency = $this->model->find($org_id);
            $user = $agency->organization_users()->find($user_id);

            $data = compact('user');
            return response()->json(['status' => true, 'data' => $data]);
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function getUsers($org_id)
    {
        try {
            $agency = $this->model->find($org_id);
            $users = $agency->organization_users()->latest('id')->get();

            $data = compact('users');
            return response()->json(['status' => true, 'data' => $data]);
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }
}
