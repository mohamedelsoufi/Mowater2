<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Http\Requests\RentalOfficeCarRequest;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\CarClass;

class OrgRentalOfficeCarController extends Controller
{
    public function index()
    {
        $user               = auth()->guard('web')->user();
        $organization       = $user->organizable;
        $rental_office_cars = $organization->rental_office_cars;
        $brands             = Brand::get();
        $car_classes        = CarClass::get();


        return view('organization.rental_office_cars.index' , compact('organization' , 'rental_office_cars' , 'brands' , 'car_classes'));
    }

    public function create()
    {
        return view('organization.rental_office_cars.create');
    }

    public function store(RentalOfficeCarRequest $request)
    {


        if($request->has('available') && $request->available )
        {
            $request->merge([
                'available' => true
            ]);
        }

        $user         = auth()->guard('web')->user();
        $organization = $user->organizable;

        $organization->rental_office_cars()->create($request->all());

        return redirect()->route('organization.rental_office_car.index')->with('success' , __('message.created_successfully'));
    }

    public function show($id)
    {
        $user         = auth()->guard('web')->user();
        $organization = $user->organizable;

        $rental_office_car = $organization->rental_office_cars()->with('car_model')->where('rental_office_cars.id' , $id)->firstOrFail();
        $data = compact('rental_office_car');
        return response()->json(['status' => true, 'data'=>$data]);
    }

    public function edit($id)
    {
        $user         = auth()->guard('web')->user();
        $organization = $user->organizable;

        $rental_office_car = $organization->rental_office_cars()->where('rental_office_cars.id' , $id)->firstOrFail();

        return view('organization.rental_office_cars.edit' , compact('organization' , 'rental_office_car'));
    }


    public function update(RentalOfficeCarRequest $request , $id)
    {
//        $rules = [
//            'car_model_id'         => 'required|exists:car_models,id',
//            'car_class_id'         => 'required|exists:car_classes,id',
//            'manufacture_year'     => 'required|max:255',
//            'color'                => 'required|max:255',
//            'daily_rental_price'   => 'nullable|numeric',
//            'weekly_rental_price'  => 'nullable|numeric',
//            'monthly_rental_price' => 'nullable|numeric',
//            'yearly_rental_price'  => 'nullable|numeric',
//            'available'            => 'nullable'
//        ];
//        $validator = validator()->make($request->all() , $rules);
//        if($validator->fails())
//        {
//            $validator->errors()->add('update_modal', $request->id);
//            return redirect()->back()->withInput()->withErrors($validator);
//        }

        if($request->has('available') && $request->available )
        {
            $request->merge([ 'available' => true]);
        }
        else
        {
            $request->merge([ 'available' => false]);
        }

        $user         = auth()->guard('web')->user();
        $organization = $user->organizable;

        $rental_office_car = $organization->rental_office_cars()->where('rental_office_cars.id' , $id)->firstOrFail();


        if($rental_office_car)
        {
            $rental_office_car->update($request->all());
            return redirect()->route('organization.rental_office_car.index')->with('success' , __('message.updated_successfully'));
        }
        else
        {
            return back()->with(['error'=> __('message.something_wrong')]);
        }
    }

    public function destroy($id)
    {
        $user         = auth()->guard('web')->user();
        $organization = $user->organizable;

        $rental_office_car = $organization->rental_office_cars()->where('rental_office_cars.id' , $id)->firstOrFail();

        if($rental_office_car)
        {
            $rental_office_car->delete();
            return redirect()->route('organization.rental_office_car.index')->with('success' , __('message.deleted_successfully'));
        }
        else
        {
            return back()->with(['error'=> __('message.something_wrong')]);
        }
    }


}
