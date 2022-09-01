<?php

namespace App\Http\Controllers\Dashboard\Organizations;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminDeliveryRequest;
use App\Http\Requests\DeliveryRequest;
use App\Models\Area;
use App\Models\Brand;
use App\Models\CarClass;
use App\Models\CarModel;
use App\Models\City;
use App\Models\Country;
use App\Models\DeliveryMan;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class DeliveryController extends Controller
{

    public function index()
    {

        $delivery_men = DeliveryMan::latest('id')->get();
        $countries = Country::all();
        $cities = City::all();
        $areas = Area::all();
        $brands = Brand::all();
//        $car_models = CarModel::all();
        $car_classes = CarClass::all();
        $reservation_cost = Section::where('ref_name', 'DeliveryMan')->first()->reservation_cost;
        $section = Section::where('ref_name', 'DeliveryMan')->first();
        $categories = $section->categories;
        return view('dashboard.organizations.delivery.index', compact('delivery_men', 'countries', 'cities', 'areas', 'brands', 'car_classes', 'reservation_cost', 'categories'));

    }


//    public function create()
//    {
//        //
//    }


    public function store(AdminDeliveryRequest $request)
    {

        if (!$request->has('active'))
            $request->request->add(['active' => 0]);
        else
            $request->request->add(['active' => 1]);

        $request_data = $request->except(['_token', 'profile_picture']);

        $date = str_replace(',', '', $request->birth_date);

//        return date('Y-m-d', strtotime($date));

//        return date('d-m-Y', strtotime($request->birth_date))
        $request_data['birth_date'] = date('Y-m-d', strtotime($date));

        if ($request->has('profile_picture')) {
            $image = $request->profile_picture->store('profile_pictures');
            $request_data['profile_picture'] = $image;
        }
        $delivery = DeliveryMan::create($request_data);
        if ($request->has('image')) {
            $delivery->uploadImage();
//            return $product;
        }
        if ($delivery) {
            $delivery->organization_users()->create([
                'user_name' => $request->user_name,
                'email' => $request->email,
                'password' => $request->password
            ]);
            return redirect()->route('delivery.index')->with(['success' => __('message.created_successfully')]);
        }
        return redirect()->route('delivery.index')->with(['error' => __('message.something_wrong')]);

    }

    public function show($id)
    {
        $show_delivery = DeliveryMan::with('brand', 'car_class', 'car_model', 'file')->find($id);
        $show_delivery->makeVisible('name_en', 'name_ar', 'description_ar', 'description_en');
//        $hour_price = Section::where('ref_name', 'DrivingTrainer')->first()->reservation_cost;
        $users = $show_delivery->organization_users()->get();
        $data = compact('show_delivery', 'users');
        return response()->json(['status' => true, 'data' => $data]);
    }

    public function getUser($org_id, $user_id)
    {
        $show_delivery = DeliveryMan::find($org_id);
        $user = $show_delivery->organization_users()->find($user_id);

        $data = compact('user');
        return response()->json(['status' => true, 'data' => $data]);
    }

//    public function edit($id)
//    {
//        //
//    }

    public function update(DeliveryRequest $request)
    {
        $delivery = DeliveryMan::find($request->id);
        if (!$request->has('active')) {
            $request->request->add(['active' => 0]);
        } else
            $request->request->add(['active' => 1]);

        $request_data = $request->except(['_token', 'profile_picture', 'user_name', 'password', 'password_confirmation']);
//        $date = '4 June 2020';

        $date = str_replace(',', '', $request->birth_date);

//        return date('Y-m-d', strtotime($date));

//        return date('d-m-Y', strtotime($request->birth_date))
        $request_data['birth_date'] = date('Y-m-d', strtotime($date));

        if ($request->has('profile_picture')) {
            $image_path = public_path('uploads/');

            if (File::exists($image_path . $delivery->getRawOriginal('profile_picture'))) {
                File::delete($image_path . $delivery->getRawOriginal('profile_picture'));
            }

            $image = $request->profile_picture->store('profile_pictures');
            $request_data['profile_picture'] = $image;
        }
        if ($request->hasFile('image')) {
            $delivery->updateImage();
        }

        $user = $delivery->organization_users()->find($request->organization_user_id);
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

        $delivery->update($request_data);
        if ($delivery) {
            return redirect()->route('delivery.index')->with(['success' => __('message.updated_successfully')]);
        } else {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delivery = DeliveryMan::find($id);
        $image_path = public_path('uploads/');
        if ($delivery->profile_picture) {
            if (File::exists($image_path . $delivery->getRawOriginal('profile_picture'))) {
                File::delete($image_path . $delivery->getRawOriginal('profile_picture'));
            }
        }
        $user = $delivery->organization_users();
        $user->delete();
        $delivery->deleteImage();

        $delivery->delete();
        return redirect()->route('delivery.index')->with(['success' => __('message.deleted_successfully')]);
    }
}
