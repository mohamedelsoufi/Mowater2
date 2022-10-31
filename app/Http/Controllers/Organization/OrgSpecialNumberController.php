<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Http\Requests\SpecialNumberRequest;
use App\Models\SpecialNumber;
use App\Models\SpecialNumberCategory;
use App\Models\SpecialNumberOrganization;
use App\Models\SpecialNumberReservation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrgSpecialNumberController extends Controller
{
    public function index()
    {
        $user = auth()->guard('web')->user();

        $model_type = $user->organizable_type;
        $model_id = $user->organizable_id;
        $model = new $model_type;
        $record = $model->find($model_id);
        $special_numbers = $record->special_numbers()->latest('id')->get();
        $special_number_categories = SpecialNumberCategory::all();

        return view('organization.special_numbers.index',
            compact('special_numbers', 'special_number_categories','record'));
    }


    public function create()
    {
        //
    }


    public function store(SpecialNumberRequest $request)
    {
        //        return $request;
        $user = auth()->guard('web')->user();

        $model_type = $user->organizable_type;
        $model_id = $user->organizable_id;
        $model = new $model_type;
        $record = $model->find($model_id);

        if (!$request->has('availability'))
            $request->request->add(['availability' => 0]);
        else
            $request->request->add(['availability' => 1]);



        $request_data = $request->except(['_token']);

        $special_number = $record->special_numbers()->create($request_data);

        if ($special_number) {
            return redirect()->route('organization.special-numbers.index')->with(['success' => __('message.created_successfully')]);
        } else {

            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }


    public function show($id)
    {
        $user = auth()->guard('web')->user();

        $model_type = $user->organizable_type;
        $model_id = $user->organizable_id;
        $model = new $model_type;
        $organization = $model->find($model_id);
        $special_number = $organization->special_numbers()->with('special_number_category')->get();

        $show_special_number = $special_number->find($id);
        $size = $show_special_number->getRawOriginal('size');
        $transfer_type = $show_special_number->getRawOriginal('transfer_type');
        $main_category = $show_special_number->special_number_category->getRawOriginal('main_category');

        $data = compact('show_special_number','main_category','size','transfer_type');
        return response()->json(['status' => true, 'data' => $data]);
    }


    public function edit($id)
    {
        //
    }


    public function update(SpecialNumberRequest $request, $id)
    {
        $special_number = SpecialNumber::find($id);
        if (!$request->has('availability'))
            $request->request->add(['availability' => 0]);
        else
            $request->request->add(['availability' => 1]);

        $request_data = $request->except(['_token']);


        $special_number->update($request_data);


        if ($special_number) {
            return redirect()->route('organization.special-numbers.index')->with(['success' => __('message.updated_successfully')]);
        } else {

            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }


    public function destroy($id)
    {
        $special_number = SpecialNumber::find($id);

        $special_number->delete();
        return redirect()->route('organization.special-numbers.index')->with(['success'=> __('message.deleted_successfully')]);
    }

    public function reservation(){
        $user = auth()->guard('web')->user();
        $model_type = $user->organizable_type;
        $model_id = $user->organizable_id;
        $model = new $model_type;
        $record = $model->find($model_id);
        $reservations = $record->special_number_reservation()->get();

        return view('organization.special_numbers.reservations.index',
            compact('reservations','record'));
    }

    public function show_reservation($id){
        $user = auth()->guard('web')->user();
        $model_type = $user->organizable_type;
        $model_id = $user->organizable_id;
        $model = new $model_type;
        $record = $model->find($model_id);
        $reservations = $record->special_number_reservation()->with('user','special_number')->get();

        $show_reservation = $reservations->find($id);

        $data = compact('show_reservation');
        return response()->json(['status' => true, 'data' => $data]);
    }

    public function update_reservation_status(Request $request, $id){
        $validator = Validator::make($request->all(),[
            'status' => 'required|in:pending,approved,rejected',
        ]);
        if ($validator->fails())
            return redirect()->route('organization.special-number-reservations')->with(['error' => __('message.something_wrong')]);

        $special_number_reservation = SpecialNumberReservation::find($id);

        $special_number_reservation->update($request->only('status'));
        return redirect()->route('organization.special-number-reservations')->with(['success' => __('message.updated_successfully')]);

    }
}
