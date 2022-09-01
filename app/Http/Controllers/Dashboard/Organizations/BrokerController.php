<?php

namespace App\Http\Controllers\Dashboard\Organizations;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminBrokerRequestRequest;
use App\Models\Broker;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Http\Requests\BrokerRequest;

class BrokerController extends Controller
{

    public function index()
    {
        $brokers = Broker::latest('id')->get();
        $countries = Country::all();
        return view('dashboard.organizations.brokers.index', compact('brokers', 'countries'));
    }

//    public function create()
//    {
//
//    }

    public function store(AdminBrokerRequestRequest $request)
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
        $broker = Broker::create($request_data);
        if ($broker) {
            $broker->organization_users()->create([
                'user_name' => $request->user_name,
                'email' => $request->email,
                'password' => $request->password
            ]);
            return redirect()->route('brokers.index')->with(['success' => __('message.created_successfully')]);
        }
        return redirect()->route('brokers.index')->with(['error' => __('message.something_wrong')]);
    }


    public function show($id)
    {
        $show_broker = broker::find($id);
        $show_broker->makeVisible('name_en', 'name_ar', 'description_ar', 'description_en');
        $users = $show_broker->organization_users()->get();

        $data = compact('show_broker','users');
        return response()->json(['status' => true, 'data' => $data]);
    }

    public function getUser($org_id,$user_id)
    {
        $show_broker = broker::find($org_id);
        $user = $show_broker->organization_users()->find($user_id);

        $data = compact('user');
        return response()->json(['status' => true, 'data' => $data]);
    }

//    public function edit($id)
//    {
//    }

    public function update(BrokerRequest $request, $id)
    {

        $broker = Broker::find($id);
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

            if (File::exists($image_path . $broker->getRawOriginal('logo'))) {
                File::delete($image_path . $broker->getRawOriginal('logo'));
            }

            $image = $request->logo->store('logos');
            $request_data['logo'] = $image;
        }
//        return $request_data;

        $user = $broker->organization_users()->find($request->organization_user_id);
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

        $broker->update($request_data);
        if ($broker) {
            return redirect()->route('brokers.index')->with(['success' => __('message.updated_successfully')]);
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
        $broker = Broker::find($id);
        $image_path = public_path('uploads/');
        if (File::exists($image_path . $broker->getRawOriginal('logo'))) {
            File::delete($image_path . $broker->getRawOriginal('logo'));
        }
        $broker->delete();
        return redirect()->route('brokers.index')->with(['success' => __('message.deleted_successfully')]);
    }
}
