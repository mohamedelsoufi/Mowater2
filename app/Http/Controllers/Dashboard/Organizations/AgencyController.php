<?php

namespace App\Http\Controllers\Dashboard\Organizations;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminAgencyRequest;
use App\Models\Agency;
use App\Models\Area;
use App\Models\Brand;
use App\Models\City;
use App\Models\Country;
use App\Models\Permission;
use App\Models\SpecialNumberOrganization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AgencyController extends Controller
{
    private $model;
    private $country;
    private $city;
    private $area;
    private $brand;

    public function __construct(Agency $model, Country $country, City $city, Area $area, Brand $brand)
    {
        $this->middleware(['permission:read-agencies'])->only('index');
        $this->middleware(['permission:create-agencies'])->only('create');
        $this->middleware(['permission:update-agencies'])->only('edit');
        $this->middleware(['permission:delete-agencies'])->only('delete');

        $this->model = $model;
        $this->brand = $brand;
        $this->country = $country;
        $this->city = $city;
        $this->area = $area;
    }

    public function index()
    {
        try {
            $agencies = $this->model->latest('id')->get();
            return view('admin.organizations.agencies.index', compact('agencies'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function create()
    {
        try {
            $countries = $this->country->latest('id')->get();
            $brands = $this->brand->latest('id')->get();
            return view('admin.organizations.agencies.create', compact('countries','brands'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    private function getModelById($id)
    {
        $model = $this->model->find($id);
        return $model;
    }

    public function store(AdminAgencyRequest $request)
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

            $request_data = $request->except(['_token', 'logo']);
            $request_data['created_by'] = auth('admin')->user()->email;
            if ($request->has('logo')) {
                $image = $request->logo->store('logos');
                $request_data['logo'] = $image;
            }

            $agency = $this->model->create($request_data);

            createMasterOrgUser($agency);

            return redirect()->route('agencies.index')->with(['success' => __('message.created_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function show($id)
    {
        try {
            $agency = $this->getModelById($id);
            $users = $agency->organization_users()->latest('id')->get();
            return view('admin.organizations.agencies.show', compact('agency', 'users'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function edit($id)
    {
        try {
            $agency = $this->getModelById($id);
            $brands = $this->brand->get();
            $users = $agency->organization_users()->get();
            $countries = $this->country->latest('id')->get();
            $cities = $this->city->latest('id')->get();
            $areas = $this->area->latest('id')->get();
            return view('admin.organizations.agencies.edit', compact('agency', 'users', 'countries', 'cities', 'areas','brands'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function update(AdminAgencyRequest $request, $id)
    {
        try {
            $agency = $this->getModelById($id);
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

            $request_data = $request->except(['_token', 'logo', 'user_name', 'password', 'password_confirmation']);
            $request_data['created_by'] = auth('admin')->user()->email;
            if ($request->has('logo')) {
                $image_path = public_path('uploads/');

                if (File::exists($image_path . $agency->getRawOriginal('logo'))) {
                    File::delete($image_path . $agency->getRawOriginal('logo'));
                }

                $image = $request->logo->store('logos');
                $request_data['logo'] = $image;
            }

            $user = $agency->organization_users()->find($request->organization_user_id);
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

            $agency->update($request_data);

            return redirect()->route('agencies.index')->with(['success' => __('message.updated_successfully')]);

        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function destroy($id)
    {
        try {
            $agency = $this->getModelById($id);

            $image_path = public_path('uploads/');
            if (File::exists($image_path . $agency->getRawOriginal('logo'))) {
                File::delete($image_path . $agency->getRawOriginal('logo'));
            }
            $user = $agency->organization_users();
            $user->delete();
            $agency->delete();
            return redirect()->route('agencies.index')->with(['success' => __('message.deleted_successfully')]);
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
            return responseJson(0,'error',$e->getMessage());
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
            return responseJson(0,'error',$e->getMessage());
        }
    }

}
