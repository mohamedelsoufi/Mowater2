<?php

namespace App\Http\Controllers\Dashboard\Organizations;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminInsuranceCompanyRequest;
use App\Models\InsuranceCompany;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class InsuranceCompanyController extends Controller
{

    public function index()
    {
        $insurance_companies = InsuranceCompany::latest('id')->get();
        $countries = Country::all();
        return view('dashboard.organizations.insurance_companies.index', compact('insurance_companies', 'countries'));
    }


    public function create()
    {
        //
    }


    public function store(AdminInsuranceCompanyRequest $request)
    {
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

        $request_data = $request->except(['_token', 'logo']);

        if ($request->has('logo')) {
            $image = $request->logo->store('logos');
            $request_data['logo'] = $image;
        }

        $insurance_company = InsuranceCompany::create($request_data);

        if ($insurance_company) {
            $insurance_company->organization_users()->create([
                'user_name' => $request->user_name,
                'email' => $request->email,
                'password' => $request->password,
            ]);
            return redirect()->route('insurance_companies.index')->with(['success' => __('message.created_successfully')]);
        } else {

            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }

    }


    public function show($id)
    {
        $show_insurance_company = InsuranceCompany::find($id);
        $show_insurance_company->makeVisible('name_en', 'name_ar', 'description_en', 'description_ar');
        $users = $show_insurance_company->organization_users()->get();

        $data = compact('show_insurance_company', 'users');
        return response()->json(['status' => true, 'data' => $data]);
    }

    public function getUser($org_id, $user_id)
    {
        $show_insurance_company = InsuranceCompany::find($org_id);
        $user = $show_insurance_company->organization_users()->find($user_id);

        $data = compact('user');
        return response()->json(['status' => true, 'data' => $data]);
    }


    public function edit($id)
    {
        //
    }


    public function update(InsuranceCompanyRequest $request, $id)
    {
        $insurance_company = InsuranceCompany::find($id);
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

        $request_data = $request->except(['_token', 'logo', 'user_name', 'password', 'password_confirmation']);

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


        if ($insurance_company) {
            return redirect()->route('insurance_companies.index')->with(['success' => __('message.updated_successfully')]);
        } else {

            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }


    public function destroy($id)
    {
        $insurance_company = InsuranceCompany::find($id);

        $image_path = public_path('uploads/');
        if (File::exists($image_path . $insurance_company->getRawOriginal('logo'))) {
            File::delete($image_path . $insurance_company->getRawOriginal('logo'));
        }
        $insurance_company->delete();
        return redirect()->route('insurance_companies.index')->with(['success' => __('message.deleted_successfully')]);

    }
}
