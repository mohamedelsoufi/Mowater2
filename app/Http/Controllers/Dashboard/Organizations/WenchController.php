<?php

namespace App\Http\Controllers\Dashboard\Organizations;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminWenchRequest;
use App\Models\Country;
use App\Models\Wench;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class WenchController extends Controller
{
    public function index()
    {
        $wenches = Wench::latest('id')->get();
        $countries = Country::all();
        return view('dashboard.organizations.wenches.index', compact('wenches', 'countries'));
    }


    public function create()
    {
        //
    }


    public function store(AdminWenchRequest $request)
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

        $wench = Wench::create($request_data);

        if ($wench) {
            $wench->organization_users()->create([
                'user_name' => $request->user_name,
                'email' => $request->email,
                'password' => $request->password,
            ]);
            return redirect()->route('wenches.index')->with(['success' => __('message.created_successfully')]);
        } else {

            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }


    public function show($id)
    {
        $show_wench = Wench::find($id);
        $show_wench->makeVisible('name_en', 'name_ar', 'description_en', 'description_ar');
        $users = $show_wench->organization_users()->get();

        $data = compact('show_wench', 'users');
        return response()->json(['status' => true, 'data' => $data]);
    }

    public function getUser($org_id, $user_id)
    {
        $show_wench = Wench::find($org_id);
        $user = $show_wench->organization_users()->find($user_id);

        $data = compact('user');
        return response()->json(['status' => true, 'data' => $data]);
    }

    public function edit($id)
    {
        //
    }


    public function update(AdminWenchRequest $request, $id)
    {
//        return $request;
        $wench = Wench::find($id);
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

            if (File::exists($image_path . $wench->getRawOriginal('logo'))) {
                File::delete($image_path . $wench->getRawOriginal('logo'));
            }

            $image = $request->logo->store('logos');
            $request_data['logo'] = $image;
        }

        $user = $wench->organization_users()->find($request->organization_user_id);
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

        $wench->update($request_data);


        if ($wench) {
            return redirect()->route('wenches.index')->with(['success' => __('message.updated_successfully')]);
        } else {

            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }


    public function destroy($id)
    {
        $wench = Wench::find($id);

        $image_path = public_path('uploads/');
        if (File::exists($image_path . $wench->getRawOriginal('logo'))) {
            File::delete($image_path . $wench->getRawOriginal('logo'));
        }
        $wench->delete();
        return redirect()->route('wenches.index')->with(['success' => __('message.deleted_successfully')]);
    }
}
