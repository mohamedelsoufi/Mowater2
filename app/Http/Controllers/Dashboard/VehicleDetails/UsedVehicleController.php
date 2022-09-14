<?php

namespace App\Http\Controllers\Dashboard\VehicleDetails;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\Brand;
use App\Models\CarClass;
use App\Models\CarModel;
use App\Models\City;
use App\Models\Color;
use App\Models\Country;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class UsedVehicleController extends Controller
{
    private $model;
    private $country;
    private $city;
    private $area;
    private $brand;
    private $carModel;
    private $carClass;
    private $color;

    public function __construct(Vehicle $model, Country $country, City $city, Area $area, Brand $brand, CarModel $carModel, CarClass $carClass, Color $color)
    {
        $this->middleware(['permission:read-used_vehicles'])->only('index');
        $this->middleware(['permission:create-used_vehicles'])->only('create');
        $this->middleware(['permission:update-used_vehicles'])->only('edit');
        $this->middleware(['permission:delete-used_vehicles'])->only('delete');

        $this->model = $model;
        $this->city = $city;
        $this->country = $country;
        $this->city = $city;
        $this->area = $area;
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
            return view('admin.vehicle_details.usedVehicles.create', compact('countries', 'brands', 'car_classes','colors'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }

    }

    public function store(Request $request)
    {
        //
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
//            return dd($vehicle->vehicleProperties());
            $keys = array_keys($vehicle->vehicleProperties());
            return view('admin.vehicle_details.usedVehicles.show', compact('vehicle', 'keys'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
