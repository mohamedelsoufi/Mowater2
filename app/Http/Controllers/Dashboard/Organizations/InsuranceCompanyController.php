<?php

namespace App\Http\Controllers\Dashboard\Organizations;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminInsuranceCompanyRequest;
use App\Models\Area;
use App\Models\City;
use App\Models\InsuranceCompany;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class InsuranceCompanyController extends Controller
{
    private $model;
    private $country;
    private $city;
    private $area;

    public function __construct(InsuranceCompany $model, Country $country, City $city, Area $area)
    {
        $this->middleware(['permission:read-insurance_companies'])->only('index');
        $this->middleware(['permission:create-insurance_companies'])->only('create');
        $this->middleware(['permission:update-insurance_companies'])->only('edit');
        $this->middleware(['permission:delete-insurance_companies'])->only('delete');

        $this->model = $model;
        $this->country = $country;
        $this->city = $city;
        $this->area = $area;
    }

    public function index()
    {
        try {
            $insurance_companies = $this->model->latest('id')->get();
            return view('admin.organizations.insurance_companies.index', compact('insurance_companies'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function create()
    {
        try {
            $countries = $this->country->latest('id')->get();
            return view('admin.organizations.insurance_companies.create', compact('countries'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function store(AdminInsuranceCompanyRequest $request)
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

            if ($request->has('logo')) {
                $image = $request->logo->store('logos');
                $request_data['logo'] = $image;
            }

            $insurance_company = $this->model->create($request_data);

            $insurance_company->organization_users()->create([
                'user_name' => $request->user_name,
                'email' => $request->email,
                'password' => $request->password,
            ]);
            return redirect()->route('insurance_companies.index')->with(['success' => __('message.created_successfully')]);
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
            $insurance_company = $this->getModelById($id);
            $users = $insurance_company->organization_users()->get();
            return view('admin.organizations.insurance_companies.show', compact('insurance_company', 'users'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function edit($id)
    {
        try {
            $insurance_company = $this->getModelById($id);
            $users = $insurance_company->organization_users()->get();
            $countries = $this->country->latest('id')->get();
            $cities = $this->city->latest('id')->get();
            $areas = $this->area->latest('id')->get();
            return view('admin.organizations.insurance_companies.edit', compact('insurance_company', 'users', 'countries', 'cities', 'areas'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function update(AdminInsuranceCompanyRequest $request, $id)
    {
        try {
            $insurance_company = $this->getModelById($id);
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

            if ($request->has('logo')) {
                $image_path = public_path('uploads/');
                if (File::exists($image_path . $insurance_company->getRawOriginal('logo'))) {
                    File::delete($image_path . $insurance_company->getRawOriginal('logo'));
                }
                $image = $request->logo->store('logos');
                $request_data['logo'] = $image;
            }
            $user = $insurance_company->organization_users()->find($request->organization_user_id);
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
            $insurance_company->update($request_data);
            return redirect()->route('insurance_companies.index')->with(['success' => __('message.updated_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function destroy($id)
    {
        try {
            $insurance_company = $this->getModelById($id);
            $image_path = public_path('uploads/');
            if (File::exists($image_path . $insurance_company->getRawOriginal('logo'))) {
                File::delete($image_path . $insurance_company->getRawOriginal('logo'));
            }
            $insurance_company->delete();
            return redirect()->route('insurance_companies.index')->with(['success' => __('message.deleted_successfully')]);
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
