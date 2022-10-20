<?php

namespace App\Http\Controllers\Dashboard\Organizations;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminSpecialNumberOrganizationRequest;
use App\Models\Agency;
use App\Models\Area;
use App\Models\City;
use App\Models\Country;
use App\Models\SpecialNumberOrganization;
use Illuminate\Support\Facades\File;

class SpecialNumberOrganizationController extends Controller
{
    private $model;
    private $country;
    private $city;
    private $area;

    public function __construct(SpecialNumberOrganization $model, Country $country, City $city, Area $area)
    {
        $this->middleware(['permission:read-special_numbers_organizations'])->only('index');
        $this->middleware(['permission:create-special_numbers_organizations'])->only('create');
        $this->middleware(['permission:update-special_numbers_organizations'])->only('edit');
        $this->middleware(['permission:delete-special_numbers_organizations'])->only('delete');


        $this->model = $model;
        $this->country = $country;
        $this->city = $city;
        $this->city = $city;
        $this->area = $area;
    }

    public function index()
    {
        try {
            $organizations = $this->model->latest('id')->get();
            return view('admin.organizations.special_numbers.special_number_organizations.index', compact('organizations'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function create()
    {
        try {
            $countries = $this->country->latest('id')->get();
            return view('admin.organizations.special_numbers.special_number_organizations.create', compact('countries'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function store(AdminSpecialNumberOrganizationRequest $request)
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

            $request_data = $request->except(['_token', 'logo', 'email', 'user_name', 'password', 'password_confirmation']);
            $request_data['created_by'] = auth('admin')->user()->email;
            if ($request->has('logo')) {
                $image = $request->logo->store('logos');
                $request_data['logo'] = $image;
            }

            $organization = $this->model->create($request_data);

            createMasterOrgUser($organization);
            return redirect()->route('special-number-organizations.index')->with(['success' => __('message.created_successfully')]);

        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
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
            $organization = $this->getModelById($id);
            $users = $organization->organization_users()->latest('id')->get();
            return view('admin.organizations.special_numbers.special_number_organizations.show', compact('organization', 'users'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function edit($id)
    {
        try {
            $countries = $this->country->latest('id')->get();
            $cities = $this->city->latest('id')->get();
            $areas = $this->area->latest('id')->get();
            $organization = $this->getModelById($id);
            $users = $organization->organization_users()->latest('id')->get();
            return view('admin.organizations.special_numbers.special_number_organizations.edit',
                compact('organization', 'users', 'countries', 'cities', 'areas'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function update(AdminSpecialNumberOrganizationRequest $request, $id)
    {
        try {
            $organization = $this->getModelById($id);
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

            $request_data = $request->except(['_token', 'logo', 'organization_user_id', 'user_name', 'password', 'password_confirmation']);
            $request_data['created_by'] = auth('admin')->user()->email;
            if ($request->has('logo')) {
                $image_path = public_path('uploads/');

                if (File::exists($image_path . $organization->getRawOriginal('logo'))) {
                    File::delete($image_path . $organization->getRawOriginal('logo'));
                }
                $image = $request->logo->store('logos');
                $request_data['logo'] = $image;
            }
            $user = $organization->organization_users()->find($request->organization_user_id);
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
            $organization->update($request_data);
            return redirect()->route('special-number-organizations.index')->with(['success' => __('message.updated_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function destroy($id)
    {
        try {
            $organization = $this->getModelById($id);

            $image_path = public_path('uploads/');
            if (File::exists($image_path . $organization->getRawOriginal('logo'))) {
                File::delete($image_path . $organization->getRawOriginal('logo'));
            }
            $organization->delete();
            return redirect()->route('special-number-organizations.index')->with(['success' => __('message.deleted_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function getUser($org_id, $user_id)
    {
        try {
            $organization = $this->model->find($org_id);
            $user = $organization->organization_users()->find($user_id);

            $data = compact('user');
            return response()->json(['status' => true, 'data' => $data]);
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function getUsers($org_id)
    {
        try {
            $organization = $this->model->find($org_id);
            $users = $organization->organization_users()->latest('id')->get();

            $data = compact('users');
            return response()->json(['status' => true, 'data' => $data]);
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }
}
