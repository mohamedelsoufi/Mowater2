<?php

namespace App\Http\Controllers\Dashboard\Organizations;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminAgencyRequest;
use App\Models\Agency;
use App\Models\Brand;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AgencyController extends Controller
{

    public function index()
    {
        $agencies = Agency::latest('id')->get();
        $brands = Brand::all();
        $countries = Country::all();
        return view('dashboard.organizations.agencies.index', compact('agencies', 'brands', 'countries'));
    }


    public function create()
    {
        //
    }


    public function store(AdminAgencyRequest $request)
    {
//        return $request;
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

        $agency = Agency::create($request_data);

        if ($agency) {
            $agency->organization_users()->create([
                'user_name' => $request->user_name,
                'email' => $request->email,
                'password' => $request->password,
            ]);
            return redirect()->route('agencies.index')->with(['success' => __('message.created_successfully')]);
        } else {

            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }

    }


    public function show($id)
    {
        $show_agency = Agency::find($id);
        $show_agency->makeVisible('name_en', 'name_ar', 'description_en', 'description_ar');
        $users = $show_agency->organization_users()->get();

        $data = compact('show_agency','users');
        return response()->json(['status' => true, 'data' => $data]);
    }

    public function getUser($org_id,$user_id)
    {
        $show_agency = Agency::find($org_id);
        $user = $show_agency->organization_users()->find($user_id);

        $data = compact('user');
        return response()->json(['status' => true, 'data' => $data]);
    }

    public function edit($id)
    {
        //
    }


    public function update(AdminAgencyRequest $request, $id)
    {
//        return $request;
        $agency = Agency::find($id);
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

        $request_data = $request->except(['_token', 'logo','user_name','password', 'password_confirmation']);

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
        if ($request->password){

            $user->update([
                'password' => $request->password,
            ]);
        }

        $agency->update($request_data);


        if ($agency) {
            return redirect()->route('agencies.index')->with(['success' => __('message.updated_successfully')]);
        } else {

            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }


    public function destroy($id)
    {
        $agency = Agency::find($id);

        $image_path = public_path('uploads/');
        if (File::exists($image_path . $agency->getRawOriginal('logo'))) {
            File::delete($image_path . $agency->getRawOriginal('logo'));
        }
        $user = $agency->organization_users();
        $user->delete();
        $agency->delete();
        return redirect()->route('agencies.index')->with(['success' => __('message.deleted_successfully')]);

    }

}
