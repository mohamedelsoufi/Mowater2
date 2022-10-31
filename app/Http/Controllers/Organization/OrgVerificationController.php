<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Models\SpecialNumberReservation;
use App\Models\Verification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrgVerificationController extends Controller
{

    public function index()
    {
        $user = auth()->guard('web')->user();
        $model_type = $user->organizable_type;
        $model_id = $user->organizable_id;
        $model = new $model_type;
        $record = $model->find($model_id);
        $verifications = $record->special_number_verification()->latest('id')->get();
        return view('organization.verifications.index',
            compact('verifications','record'));
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }


    public function show($id)
    {
        $user = auth()->guard('web')->user();

        $model_type = $user->organizable_type;
        $model_id = $user->organizable_id;
        $model = new $model_type;
        $organization = $model->find($model_id);
        $show_verification = $organization->special_number_verification()->with('model','user')->find($id);

        $data = compact('show_verification');
        return response()->json(['status' => true, 'data' => $data]);
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'status' => 'required|in:pending,available,not_available',
        ]);
        if ($validator->fails())
            return redirect()->route('organization.verifications.index')->with(['error' => __('message.something_wrong')]);

        $verification = Verification::find($id);

        $verification->update($request->only('status'));
        return redirect()->route('organization.verifications.index')->with(['success' => __('message.updated_successfully')]);

    }


    public function destroy($id)
    {
        //
    }
}
