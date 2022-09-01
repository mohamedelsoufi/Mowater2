<?php

namespace App\Http\Controllers\Dashboard\Organizations;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminFuelStationRequest;
use App\Models\Country;
use App\Models\FuelStation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class FuelStationController extends Controller
{
    public function index()
    {
        $fuel_stations = FuelStation::latest('id')->get();
        $countries = Country::all();
        return view('dashboard.organizations.fuel_stations.index', compact('fuel_stations', 'countries'));
    }


    public function create()
    {
        //
    }


    public function store(AdminFuelStationRequest $request)
    {
//        return $request;
        if (!$request->has('active'))
            $request->request->add(['active' => 0]);
        else
            $request->request->add(['active' => 1]);


        $request_data = $request->except(['_token', 'logo', 'fuel_types']);

        if ($request->has('logo')) {
            $image = $request->logo->store('logos');
            $request_data['logo'] = $image;
        }

        if ($request->has('fuel_types')) {
            $request_data['fuel_types'] = implode(",", $request->fuel_types);;
        }

        $fuel_station = FuelStation::create($request_data);

        if ($fuel_station) {
            $fuel_station->organization_users()->create([
                'user_name' => $request->user_name,
                'email' => $request->email,
                'password' => $request->password,
            ]);
            return redirect()->route('fuel-stations.index')->with(['success' => __('message.created_successfully')]);
        } else {

            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }


    public function show($id)
    {
        $show_fuel_station = FuelStation::find($id);
        $show_fuel_station->makeVisible('name_en', 'name_ar', 'address_en', 'address_ar');
        $users = $show_fuel_station->organization_users()->get();

        $data = compact('show_fuel_station', 'users');
        return response()->json(['status' => true, 'data' => $data]);
    }

    public function getUser($org_id, $user_id)
    {
        $show_fuel_station = FuelStation::find($org_id);
        $user = $show_fuel_station->organization_users()->find($user_id);

        $data = compact('user');
        return response()->json(['status' => true, 'data' => $data]);
    }

//    public function edit($id)
//    {
//        //
//    }


    public function update(AdminFuelStationRequest $request, $id)
    {
//        return $request;
        $fuel_station = FuelStation::find($id);
        if (!$request->has('active'))
            $request->request->add(['active' => 0]);
        else
            $request->request->add(['active' => 1]);

        $request_data = $request->except(['_token', 'logo', 'user_name', 'password', 'password_confirmation','fuel_types']);

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


        if ($fuel_station) {
            return redirect()->route('fuel-stations.index')->with(['success' => __('message.updated_successfully')]);
        } else {

            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }


    public function destroy($id)
    {
        $fuel_station = FuelStation::find($id);

        $image_path = public_path('uploads/');
        if (File::exists($image_path . $fuel_station->getRawOriginal('logo'))) {
            File::delete($image_path . $fuel_station->getRawOriginal('logo'));
        }
        $fuel_station->delete();
        return redirect()->route('fuel-stations.index')->with(['success' => __('message.deleted_successfully')]);
    }
}
