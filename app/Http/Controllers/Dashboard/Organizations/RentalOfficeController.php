<?php

namespace App\Http\Controllers\Dashboard\Organizations;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminRentalOfficeRequest;
use App\Models\Country;
use App\Models\RentalOffice;
use Illuminate\Support\Facades\File;

class RentalOfficeController extends Controller
{
    public function index()
    {
        $rental_offices = RentalOffice::latest('id')->get();
        $countries = Country::all();
        return view('dashboard.organizations.rental_offices.index', compact('rental_offices', 'countries'));
    }


    public function create()
    {
        //
    }


    public function store(AdminRentalOfficeRequest $request)
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

        $rental_office = RentalOffice::create($request_data);

        if ($rental_office) {
            $rental_office->organization_users()->create([
                'user_name' => $request->user_name,
                'email' => $request->email,
                'password' => $request->password,
            ]);
            return redirect()->route('rental-offices.index')->with(['success' => __('message.created_successfully')]);
        } else {

            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }


    public function show($id)
    {
        $show_rental_office = RentalOffice::find($id);
        $show_rental_office->makeVisible('name_en', 'name_ar', 'description_en', 'description_ar');
        $users = $show_rental_office->organization_users()->get();

        $data = compact('show_rental_office', 'users');
        return response()->json(['status' => true, 'data' => $data]);
    }

    public function getUser($org_id, $user_id)
    {
        $show_rental_office = RentalOffice::find($org_id);
        $user = $show_rental_office->organization_users()->find($user_id);

        $data = compact('user');
        return response()->json(['status' => true, 'data' => $data]);
    }


    public function edit($id)
    {
        //
    }


    public function update(AdminRentalOfficeRequest $request, $id)
    {
//        return $request;
        $rental_office = RentalOffice::find($id);
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

            if (File::exists($image_path . $rental_office->getRawOriginal('logo'))) {
                File::delete($image_path . $rental_office->getRawOriginal('logo'));
            }

            $image = $request->logo->store('logos');
            $request_data['logo'] = $image;
        }

        $user = $rental_office->organization_users()->find($request->organization_user_id);
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

        $rental_office->update($request_data);


        if ($rental_office) {
            return redirect()->route('rental-offices.index')->with(['success' => __('message.updated_successfully')]);
        } else {

            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }


    public function destroy($id)
    {
        $rental_office = RentalOffice::find($id);

        $image_path = public_path('uploads/');
        if (File::exists($image_path . $rental_office->getRawOriginal('logo'))) {
            File::delete($image_path . $rental_office->getRawOriginal('logo'));
        }
        $rental_office->delete();
        return redirect()->route('rental-offices.index')->with(['success' => __('message.deleted_successfully')]);
    }
}
