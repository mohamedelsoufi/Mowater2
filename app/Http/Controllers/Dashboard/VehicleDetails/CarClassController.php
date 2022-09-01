<?php

namespace App\Http\Controllers\Dashboard\VehicleDetails;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CarClassRequest;
use App\Models\CarClass;
use Illuminate\Http\Request;

class CarClassController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:read-car_classes'])->only('index');
        $this->middleware(['permission:create-car_classes'])->only('create');
        $this->middleware(['permission:update-car_classes'])->only('edit');
        $this->middleware(['permission:delete-car_classes'])->only('delete');
    }

    public function index()
    {
        try {
            $car_classes = CarClass::latest('id')->get();
            return view('admin.vehicle_details.car_classes.index', compact('car_classes'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function show($id)
    {
        try {
            $car_class = CarClass::find($id);
            return view('admin.vehicle_details.car_classes.show', compact('car_class'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function create()
    {
        return view('admin.vehicle_details.car_classes.create');
    }

    public function store(CarClassRequest $request)
    {
        try {
            if (!$request->has('active'))
                $request->request->add(['active' => 0]);
            else
                $request->request->add(['active' => 1]);
            $car_class = CarClass::create($request->except(['_token']));
            if ($car_class) {
                return redirect()->route('car-classes.index')->with(['success' => __('message.created_successfully')]);
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
            $car_class = CarClass::find($id);
            return view('admin.vehicle_details.car_classes.edit', compact('car_class'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function update(CarClassRequest $request, $id)
    {
        try {
            $car_class = CarClass::find($id);
            if (!$request->has('active'))
                $request->request->add(['active' => 0]);
            else
                $request->request->add(['active' => 1]);
            $update_car_class = $car_class->update($request->except(['_token']));
            if ($update_car_class) {
                return redirect()->route('car-classes.index')->with(['success' => __('message.updated_successfully')]);
            } else {
                return redirect()->route('car-classes.index')->with(['error' => __('message.something_wrong')]);
            }
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }


    public function destroy($id)
    {
        try {
            $car_class = CarClass::find($id);
            $car_class->delete();
            return redirect()->route('car-classes.index')->with(['success' => __('message.deleted_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }
}
