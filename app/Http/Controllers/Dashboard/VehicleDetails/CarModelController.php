<?php

namespace App\Http\Controllers\Dashboard\VehicleDetails;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CarModelRequest;
use App\Models\Brand;
use App\Models\CarModel;

class CarModelController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:read-car_models'])->only('index');
        $this->middleware(['permission:create-car_models'])->only('create');
        $this->middleware(['permission:update-car_models'])->only('edit');
        $this->middleware(['permission:delete-car_models'])->only('delete');
    }

    public function index()
    {
        try {
            $car_models = CarModel::latest('id')->get();
            $brands = Brand::all();
            return view('admin.vehicle_details.car_models.index', compact('car_models', 'brands'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }


    public function create()
    {
        try {
            $brands = Brand::active()->get();
            return view('admin.vehicle_details.car_models.create', compact('brands'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function show($id)
    {
        try {
            $car_model = CarModel::find($id);
            return view('admin.vehicle_details.car_models.show', compact('car_model'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function store(CarModelRequest $request)
    {
        try {
            if (!$request->has('active'))
                $request->request->add(['active' => 0]);
            else
                $request->request->add(['active' => 1]);
            $request['created_by'] = auth('admin')->user()->email;
            $car_model = CarModel::create($request->except(['_token']));
            if ($car_model) {
                return redirect()->route('car-models.index')->with(['success' => __('message.created_successfully')]);
            } else {

                return redirect()->back()->with(['error' => __('message.something_wrong')]);
            }
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function edit($id)
    {
        try {
            $car_model = CarModel::find($id);
            $brands = Brand::active()->get();
            return view('admin.vehicle_details.car_models.edit', compact('car_model', 'brands'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function update(CarModelRequest $request, $id)
    {
        try {
            $car_model = CarModel::find($id);
            if (!$request->has('active'))
                $request->request->add(['active' => 0]);
            else
                $request->request->add(['active' => 1]);
            $request['created_by'] = auth('admin')->user()->email;
            $update_car_model = $car_model->update($request->except(['_token']));
            if ($update_car_model) {
                return redirect()->route('car-models.index')->with(['success' => __('message.updated_successfully')]);
            } else {
                return redirect()->route('car-models.index')->with(['error' => __('message.something_wrong')]);
            }
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }


    public function destroy($id)
    {
        try {
        $car_model = CarModel::find($id);
        $car_model->delete();
        return redirect()->route('car-models.index')->with(['success' => __('message.deleted_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function get_models_of_brand($id)
    {
        $car_models = CarModel::where('brand_id', $id)->get();
        $data = compact('car_models');
        return response()->json(['status' => true, 'data' => $data]);
    }
}
