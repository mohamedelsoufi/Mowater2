<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class OrgInsuranceRequestController extends Controller
{
    public function index()
    {

        $user = auth()->guard('web')->user();
        $model_type = $user->organizable_type;
        $model_id = $user->organizable_id;
        $model = new $model_type;
        $record = $model->find($model_id);
        $insurance_requests = $record->request_insurance_organizations;
        return view('organization.insurance_requests.index', compact('insurance_requests'));
    }

    public function show($id)
    {
        $user = auth()->guard('web')->user();
        $model_type = $user->organizable_type;
        $model_id = $user->organizable_id;
        $model = new $model_type;
        $record = $model->find($model_id);
        $insurance_request = $record->request_insurance_organizations->where('id', $id)->first();

        $user = User::find($insurance_request->user_id);
        return view('organization.insurance_requests.show', compact('insurance_request', 'user'));
    }

    public function update($id)
    {
        $user = auth()->guard('web')->user();
        $model_type = $user->organizable_type;
        $model_id = $user->organizable_id;
        $model = new $model_type;
        $record = $model->find($model_id);
        $insurance_request = $record->request_insurance_organizations->where('id', $id)->first();
        return view('organization.insurance_requests.update', compact('insurance_request'));
    }

    public function update_insurance(Request $request)
    {
        $user = auth()->guard('web')->user();
        $model_type = $user->organizable_type;
        $model_id = $user->organizable_id;
        $model = new $model_type;
        $record = $model->find($model_id);
        $insurance_request = $record->request_insurance_organizations->where('id', $request->id)->first();
        $insurance_request->pivot->status = "replied";
        $insurance_request->pivot->price = $request->price;
        $insurance_request->pivot->save();
        return view('organization.insurance_requests.show', compact('insurance_request', 'user'));

    }

}
