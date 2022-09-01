<?php

namespace App\Http\Controllers\Dashboard\Organizations;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminSparepartRequest;
use App\Models\Country;
use App\Models\SparePart;
use App\Http\Requests\SparepartRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SparePartController extends Controller
{

    public function index()
    {
        $spareparts = Sparepart::latest('id')->get();
        $countries = Country::all();
        return view('dashboard.organizations.spareparts.index', compact('spareparts', 'countries'));
    }

//    public function create()
//    {
//
//    }

    public function store(AdminSparepartRequest $request)
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
//        return $request_data['logo'];
        $sparepart = Sparepart::create($request_data);
        if ($sparepart) {
            $sparepart->organization_users()->create([
                'user_name' => $request->user_name,
                'email' => $request->email,
                'password' => $request->password
            ]);
            return redirect()->route('spareparts.index')->with(['success' => __('message.created_successfully')]);
        }
        return redirect()->route('spareparts.index')->with(['error' => __('message.something_wrong')]);
    }

    public function show($id)
    {
        $show_sparepart = Sparepart::find($id);
        $show_sparepart->makeVisible('name_en', 'name_ar', 'description_ar', 'description_en');
        $users = $show_sparepart->organization_users()->get();

        $data = compact('show_sparepart', 'users');
        return response()->json(['status' => true, 'data' => $data]);
    }

    public function getUser($org_id, $user_id)
    {
        $show_sparepart = Sparepart::find($org_id);
        $user = $show_sparepart->organization_users()->find($user_id);

        $data = compact('user');
        return response()->json(['status' => true, 'data' => $data]);
    }

//    public function edit($id)
//    {
//    }

    public function update(SparepartRequest $request, $id)
    {
        $sparepart = Sparepart::find($id);
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

            if (File::exists($image_path . $sparepart->getRawOriginal('logo'))) {
                File::delete($image_path . $sparepart->getRawOriginal('logo'));
            }

            $image = $request->logo->store('logos');
            $request_data['logo'] = $image;
        }

        $user = $sparepart->organization_users()->find($request->organization_user_id);
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

        $sparepart->update($request_data);


        if ($sparepart) {
            return redirect()->route('spareparts.index')->with(['success' => __('message.updated_successfully')]);
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
        $Sparepart = Sparepart::find($id);
        $image_path = public_path('uploads/');
        if (File::exists($image_path . $Sparepart->getRawOriginal('logo'))) {
            File::delete($image_path . $Sparepart->getRawOriginal('logo'));
        }
        $user = $Sparepart->organization_users();
        $user->delete();
        $Sparepart->delete();
        return redirect()->route('spareparts.index')->with(['success' => __('message.deleted_successfully')]);

    }
}
