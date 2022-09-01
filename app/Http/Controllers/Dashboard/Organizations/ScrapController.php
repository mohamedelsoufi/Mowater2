<?php

namespace App\Http\Controllers\Dashboard\Organizations;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminScrapRequest;
use App\Models\Country;
use App\Models\Scrap;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ScrapController extends Controller
{
    public function index()
    {
        $scraps = Scrap::latest('id')->get();
        $countries = Country::all();
        return view('dashboard.organizations.scraps.index', compact('scraps', 'countries'));
    }

//    public function create()
//    {
//
//    }

    public function store(AdminScrapRequest $request)
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
        $scrap = Scrap::create($request_data);
        if ($scrap) {
            $scrap->organization_users()->create([
                'user_name' => $request->user_name,
                'email' => $request->email,
                'password' => $request->password
            ]);
            return redirect()->route('scraps.index')->with(['success' => __('message.created_successfully')]);
        }
        return redirect()->route('scraps.index')->with(['error' => __('message.something_wrong')]);
    }

    public function show($id)
    {
        $show_scrap = Scrap::find($id);
        $show_scrap->makeVisible('name_en', 'name_ar', 'description_ar', 'description_en');
        $users = $show_scrap->organization_users()->get();

        $data = compact('show_scrap', 'users');
        return response()->json(['status' => true, 'data' => $data]);
    }

    public function getUser($org_id, $user_id)
    {
        $show_scrap = Scrap::find($org_id);
        $user = $show_scrap->organization_users()->find($user_id);

        $data = compact('user');
        return response()->json(['status' => true, 'data' => $data]);
    }

//    public function edit($id)
////    {
////    }

    public function update(AdminScrapRequest $request, $id)
    {
        $scrap = Scrap::find($id);
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

            if (File::exists($image_path . $scrap->getRawOriginal('logo'))) {
                File::delete($image_path . $scrap->getRawOriginal('logo'));
            }

            $image = $request->logo->store('logos');
            $request_data['logo'] = $image;
        }

        $user = $scrap->organization_users()->find($request->organization_user_id);
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

        $scrap->update($request_data);


        if ($scrap) {
            return redirect()->route('agencies.index')->with(['success' => __('message.updated_successfully')]);
        } else {

            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function destroy($id)
    {
        $scrap = Scrap::find($id);
        $image_path = public_path('uploads/');
        if (File::exists($image_path . $scrap->getRawOriginal('logo'))) {
            File::delete($image_path . $scrap->getRawOriginal('logo'));
        }
        $scrap->delete();
        return redirect()->route('scraps.index')->with(['success' => __('message.deleted_successfully')]);

    }
}
