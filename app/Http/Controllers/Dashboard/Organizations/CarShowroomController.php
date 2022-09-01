<?php

namespace App\Http\Controllers\Dashboard\Organizations;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminCarShowroomRequest;
use App\Models\CarShowroom;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CarShowroomController extends Controller
{
    public function index()
    {
        $car_showrooms = CarShowroom::latest('id')->get();
        $countries = Country::all();
        return view('dashboard.organizations.car_showrooms.index', compact('car_showrooms', 'countries'));
    }


    public function create()
    {
        //
    }


    public function store(AdminCarShowroomRequest $request)
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

        $car_showroom = CarShowroom::create($request_data);

        if ($car_showroom) {
            $car_showroom->organization_users()->create([
                'user_name' => $request->user_name,
                'email' => $request->email,
                'password' => $request->password,
            ]);
            return redirect()->route('car-showrooms.index')->with(['success' => __('message.created_successfully')]);
        } else {

            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }


    public function show($id)
    {
        $show_car_showroom = CarShowroom::find($id);
        $show_car_showroom->makeVisible('name_en', 'name_ar', 'description_en', 'description_ar');
        $users = $show_car_showroom->organization_users()->get();

        $data = compact('show_car_showroom', 'users');
        return response()->json(['status' => true, 'data' => $data]);
    }

    public function getUser($org_id, $user_id)
    {
        $show_car_showroom = CarShowroom::find($org_id);
        $user = $show_car_showroom->organization_users()->find($user_id);

        $data = compact('user');
        return response()->json(['status' => true, 'data' => $data]);
    }

    public function edit($id)
    {
        //
    }


    public function update(AdminCarShowroomRequest $request, $id)
    {
//        return $request;
        $car_showroom = CarShowroom::find($id);
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
//return $request_data;
        if ($request->has('logo')) {
            $image_path = public_path('uploads/');

            if (File::exists($image_path . $car_showroom->getRawOriginal('logo'))) {
                File::delete($image_path . $car_showroom->getRawOriginal('logo'));
            }

            $image = $request->logo->store('logos');
            $request_data['logo'] = $image;
        }

        $user = $car_showroom->organization_users()->find($request->organization_user_id);
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

        $car_showroom->update($request_data);


        if ($car_showroom) {
            return redirect()->route('car-showrooms.index')->with(['success' => __('message.updated_successfully')]);
        } else {

            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }


    public function destroy($id)
    {
        $car_showroom = CarShowroom::find($id);

        $image_path = public_path('uploads/');
        if (File::exists($image_path . $car_showroom->getRawOriginal('logo'))) {
            File::delete($image_path . $car_showroom->getRawOriginal('logo'));
        }
        $car_showroom->delete();
        return redirect()->route('car-showrooms.index')->with(['success' => __('message.deleted_successfully')]);
    }
}
