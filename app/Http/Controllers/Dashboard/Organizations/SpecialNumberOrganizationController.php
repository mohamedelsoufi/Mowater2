<?php

namespace App\Http\Controllers\Dashboard\Organizations;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminSpecialNumberOrganizationRequest;
use App\Http\Requests\SpecialNumberOrganizationRequest;
use App\Models\Area;
use App\Models\City;
use App\Models\Country;
use App\Models\SpecialNumberOrganization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SpecialNumberOrganizationController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:read-special_numbers_organizations'])->only('index');
        $this->middleware(['permission:create-special_numbers_organizations'])->only('create');
        $this->middleware(['permission:update-special_numbers_organizations'])->only('edit');
        $this->middleware(['permission:delete-special_numbers_organizations'])->only('delete');
    }

    public function index()
    {
        try {
            $organizations = SpecialNumberOrganization::latest('id')->get();
            return view('admin.organizations.special_numbers.special_number_organizations.index', compact('organizations'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function create()
    {
        try {
            $countries = Country::latest('id')->get();
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

            if (!$request->has('reservation_active'))
                $request->request->add(['reservation_active' => 0]);
            else
                $request->request->add(['reservation_active' => 1]);

            if (!$request->has('delivery_active'))
                $request->request->add(['delivery_active' => 0]);
            else
                $request->request->add(['delivery_active' => 1]);

            $request_data = $request->except(['_token', 'logo', 'email', 'user_name', 'password', 'password_confirmation']);

            if ($request->has('logo')) {
                $image = $request->logo->store('logos');
                $request_data['logo'] = $image;
            }

            $organization = SpecialNumberOrganization::create($request_data);

            $organization->organization_users()->create([
                'user_name' => $request->user_name,
                'email' => $request->email,
                'password' => $request->password,
            ]);
            return redirect()->route('special-number-organizations.index')->with(['success' => __('message.created_successfully')]);

        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        try {
            $organization = SpecialNumberOrganization::find($id);
            $users = $organization->organization_users()->get();
            return view('admin.organizations.special_numbers.special_number_organizations.show', compact('organization', 'users'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function getUser($org_id, $user_id)
    {
        $organization = SpecialNumberOrganization::find($org_id);
        $user = $organization->organization_users()->find($user_id);

        $data = compact('user');
        return response()->json(['status' => true, 'data' => $data]);
    }

    public function getUsers($org_id)
    {
        $organization = SpecialNumberOrganization::find($org_id);
        $users = $organization->organization_users()->get();

        $data = compact('users');
        return response()->json(['status' => true, 'data' => $data]);
    }


    public function edit($id)
    {
        try {
            $countries = Country::latest('id')->get();
            $cities = City::latest('id')->get();
            $areas = Area::latest('id')->get();
            $organization = SpecialNumberOrganization::find($id);
            $users = $organization->organization_users()->get();
            return view('admin.organizations.special_numbers.special_number_organizations.edit',
                compact('organization', 'users', 'countries', 'cities', 'areas'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }


    public function update(AdminSpecialNumberOrganizationRequest $request, $id)
    {
        try {
            $organization = SpecialNumberOrganization::find($id);
            if (!$request->has('active'))
                $request->request->add(['active' => 0]);
            else
                $request->request->add(['active' => 1]);

            if (!$request->has('reservation_active'))
                $request->request->add(['reservation_active' => 0]);
            else
                $request->request->add(['reservation_active' => 1]);

            if (!$request->has('delivery_active'))
                $request->request->add(['delivery_active' => 0]);
            else
                $request->request->add(['delivery_active' => 1]);

            $request_data = $request->except(['_token', 'logo', 'organization_user_id', 'user_name', 'password', 'password_confirmation']);

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
            $organization = SpecialNumberOrganization::find($id);

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
}
