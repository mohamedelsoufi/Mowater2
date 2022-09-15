<?php

namespace App\Http\Controllers\Dashboard\VehicleDetails;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminUsedVehicleForSaleRequest;
use App\Models\Area;
use App\Models\Brand;
use App\Models\CarClass;
use App\Models\CarModel;
use App\Models\City;
use App\Models\Color;
use App\Models\Country;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class UsedVehicleController extends Controller
{
    private $model;
    private $country;
    private $brand;
    private $carModel;
    private $carClass;
    private $color;

    public function __construct(Vehicle $model, Country $country, Brand $brand, CarModel $carModel, CarClass $carClass, Color $color)
    {
        $this->middleware(['permission:read-used_vehicles'])->only('index');
        $this->middleware(['permission:create-used_vehicles'])->only('create');
        $this->middleware(['permission:update-used_vehicles'])->only('edit');
        $this->middleware(['permission:delete-used_vehicles'])->only('delete');

        $this->model = $model;
        $this->country = $country;
        $this->brand = $brand;
        $this->carModel = $carModel;
        $this->carClass = $carClass;
        $this->color = $color;
    }

    public function index()
    {
        try {
            $vehicles = $this->model->where('user_vehicle_status', 'for_sale')->latest('id')->get();
            return view('admin.vehicle_details.usedVehicles.index', compact('vehicles'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function create()
    {

        try {
            $countries = $this->country->latest('id')->get();
            $brands = $this->brand->latest('id')->get();
            $car_classes = $this->carClass->latest('id')->get();
            $colors = $this->color->get();
            return view('admin.vehicle_details.usedVehicles.create', compact('countries', 'brands', 'car_classes', 'colors'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }

    }

    public function store(AdminUsedVehicleForSaleRequest $request)
    {
        try {
            $user = auth('admin')->user();
            if (!$request->has('active'))
                $request->request->add(['active' => 0]);
            else
                $request->request->add(['active' => 1]);

            if (!$request->has('active_number_of_views'))
                $request->request->add(['active_number_of_views' => 0]);
            else
                $request->request->add(['active_number_of_views' => 1]);

            $request_data = $request->except(['_token']);

            $request_data['user_vehicle_status'] = 'for_sale';
            $request_data['is_new'] = 0;

            $used_vehicle = $user->vehicles()->create($request_data);

            $used_vehicle->upload_car_for_sale_Images();
            return redirect()->route('used-vehicles.index')->with(['success' => __('message.created_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    private function getModelById($id)
    {
        $model = $this->model->find($id);
        return $model;
    }

    public function show($id)
    {
        try {
            $vehicle = $this->getModelById($id);
            $keys = array_keys($vehicle->vehicleProperties());
            return view('admin.vehicle_details.usedVehicles.show', compact('vehicle', 'keys'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function edit($id)
    {
        try {
            $vehicle = $this->getModelById($id);
            $countries = $this->country->latest('id')->get();
            $brands = $this->brand->latest('id')->get();
            $car_classes = $this->carClass->latest('id')->get();
            $colors = $this->color->get();
            return view('admin.vehicle_details.usedVehicles.edit', compact('vehicle', 'countries', 'brands', 'car_classes', 'colors'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function update(AdminUsedVehicleForSaleRequest $request, $id)
    {
        try {
            $vehicle = $this->getModelById($id);
            if (!$request->has('active'))
                $request->request->add(['active' => 0]);
            else
                $request->request->add(['active' => 1]);

            if (!$request->has('active_number_of_views'))
                $request->request->add(['active_number_of_views' => 0]);
            else
                $request->request->add(['active_number_of_views' => 1]);

            $request_data = $request->except(['_token']);

            $request_data['user_vehicle_status'] = 'for_sale';
            $request_data['is_new'] = 0;

            $vehicle->update($request_data);
            $vehicle->updateAdminUsedVehicle();
            return redirect()->route('used-vehicles.index')->with(['success' => __('message.updated_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function destroy($id)
    {
        try {
            $vehicle = $this->getModelById($id);
            $vehicle->delete();
            $vehicle->deleteImages();
            return redirect()->route('used-vehicles.index')->with(['success' => __('message.deleted_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }
}
