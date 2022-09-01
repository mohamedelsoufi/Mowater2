<?php

namespace App\Http\Controllers\Dashboard\Organizations;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminTrainerRequest;
use App\Http\Requests\DrivingTrainerRequest;
use App\Models\CarClass;
use App\Models\Country;
use App\Models\DrivingTrainer;
use App\Models\Section;
use Illuminate\Http\Request;
use App\Models\Brand;
use Illuminate\Support\Facades\File;

class DrivingTrainersController extends Controller
{
    public function index()
    {
        $trainers = DrivingTrainer::latest('id')->get();
        $countries = Country::all();
        $brands = Brand::all();
        $car_classes = CarClass::all();
        $hour_price = Section::where('ref_name', 'DrivingTrainer')->first()->reservation_cost;

        return view('dashboard.organizations.driving_trainers.index', compact('trainers', 'countries', 'brands', 'car_classes', 'hour_price'));
    }

//    public function create()
//    {
//        //
//    }

    public function store(AdminTrainerRequest $request)
    {
//        return $request;
        if (!$request->has('active'))
            $request->request->add(['active' => 0]);
        else
            $request->request->add(['active' => 1]);

        $request_data = $request->except(['_token', 'logo']);
        $hour_price = $hour_price = Section::where('ref_name', 'DrivingTrainer')->first()->reservation_cost;
        $request_data['hour_price'] = $hour_price;

        $date = str_replace(',', '', $request->birth_date);
        $request_data['birth_date'] = date('Y-m-d', strtotime($date));
        if ($request->has('profile_picture')) {
            $image = $request->profile_picture->store('profile_pictures');
            $request_data['profile_picture'] = $image;
        }
//        return $request_data['logo'];
        $trainer = DrivingTrainer::create($request_data);
        if ($request->has('image')) {
            $trainer->uploadImage();
//            return $product;
        }
        if ($trainer) {
            $trainer->organization_users()->create([
                'user_name' => $request->user_name,
                'email' => $request->email,
                'password' => $request->password
            ]);

            return redirect()->route('trainers.index')->with(['success' => __('message.created_successfully')]);
        }
        return redirect()->route('trainers.index')->with(['error' => __('message.something_wrong')]);
    }

    public function show($id)
    {
        $show_trainer = DrivingTrainer::with('brand', 'car_model', 'file')->find($id);
        $show_trainer->makeVisible('name_en', 'name_ar', 'description_ar', 'description_en');
        $hour_price = Section::where('ref_name', 'DrivingTrainer')->first()->reservation_cost;
        $users = $show_trainer->organization_users()->get();

        $data = compact('show_trainer', 'hour_price', 'users');
        return response()->json(['status' => true, 'data' => $data]);
    }

    public function getUser($org_id, $user_id)
    {
        $show_trainer = DrivingTrainer::find($org_id);
        $user = $show_trainer->organization_users()->find($user_id);

        $data = compact('user');
        return response()->json(['status' => true, 'data' => $data]);
    }

//    public function edit($id)
//    {
//        //
//    }

    public function update(DrivingTrainerRequest $request, $id)
    {
//        return $request;

        $trainer = DrivingTrainer::find($id);
        if (!$request->has('active')) {
            $request->request->add(['active' => 0]);
        } else
            $request->request->add(['active' => 1]);

        $request_data = $request->except(['_token', 'profile_picture', 'user_name', 'password', 'password_confirmation']);

        $date = str_replace(',', '', $request->birth_date);

//        return date('Y-m-d', strtotime($date));

//        return date('d-m-Y', strtotime($request->birth_date))
        $request_data['birth_date'] = date('Y-m-d', strtotime($date));

        if ($request->has('profile_picture')) {
            $image_path = public_path('uploads/');

            if (File::exists($image_path . $trainer->getRawOriginal('profile_picture'))) {
                File::delete($image_path . $trainer->getRawOriginal('profile_picture'));
            }

            $image = $request->profile_picture->store('profile_pictures');
            $request_data['profile_picture'] = $image;
        }

        if ($request->hasFile('image')) {
            $trainer->updateImage();
        }

        $user = $trainer->organization_users()->find($request->organization_user_id);
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

        $trainer->update($request_data);
        if ($trainer) {
            return redirect()->route('trainers.index')->with(['success' => __('message.updated_successfully')]);
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

        $trainer = DrivingTrainer::find($id);

        $image_path = public_path('uploads/');
        if ($trainer->profile_picture) {
            if (File::exists($image_path . $trainer->getRawOriginal('profile_picture'))) {
                File::delete($image_path . $trainer->getRawOriginal('profile_picture'));
            }
        }

        $user = $trainer->organization_users();
        $user->delete();
        $trainer->deleteImage();
        $trainer->delete();
        return redirect()->route('trainers.index')->with(['success' => __('message.deleted_successfully')]);

    }
}
