<?php

namespace App\Http\Controllers\Dashboard\Organizations;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminGarageRequest;
use App\Models\Garage;
use App\Models\Brand;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class GarageController extends Controller
{
    public function index()
    {
        $garages = Garage::latest('id')->get();
        $countries = Country::all();
        return view('dashboard.organizations.garages.index', compact('garages', 'countries'));
    }


    public function create()
    {
        //
    }


    public function store(AdminGarageRequest $request)
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

        $garage = Garage::create($request_data);

        if ($garage) {
            $garage->organization_users()->create([
                'user_name' => $request->user_name,
                'email' => $request->email,
                'password' => $request->password,
            ]);
            return redirect()->route('garages.index')->with(['success' => __('message.created_successfully')]);
        } else {

            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }


    public function show($id)
    {
        $show_garage = Garage::find($id);
        $show_garage->makeVisible('name_en', 'name_ar', 'description_en', 'description_ar');
        $users = $show_garage->organization_users()->get();

        $data = compact('show_garage', 'users');
        return response()->json(['status' => true, 'data' => $data]);
    }

    public function getUser($org_id, $user_id)
    {
        $show_garage = Garage::find($org_id);
        $user = $show_garage->organization_users()->find($user_id);

        $data = compact('user');
        return response()->json(['status' => true, 'data' => $data]);
    }

    public function edit($id)
    {
        //
    }


    public function update(AdminGarageRequest $request, $id)
    {
//        return $request;
        $garage = Garage::find($id);
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

            if (File::exists($image_path . $garage->getRawOriginal('logo'))) {
                File::delete($image_path . $garage->getRawOriginal('logo'));
            }

            $image = $request->logo->store('logos');
            $request_data['logo'] = $image;
        }

        $user = $garage->organization_users()->find($request->organization_user_id);
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

        $garage->update($request_data);


        if ($garage) {
            return redirect()->route('garages.index')->with(['success' => __('message.updated_successfully')]);
        } else {

            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }


    public function destroy($id)
    {
        $garage = Garage::find($id);

        $image_path = public_path('uploads/');
        if (File::exists($image_path . $garage->getRawOriginal('logo'))) {
            File::delete($image_path . $garage->getRawOriginal('logo'));
        }
        $garage->delete();
        return redirect()->route('garages.index')->with(['success' => __('message.deleted_successfully')]);
    }
}
