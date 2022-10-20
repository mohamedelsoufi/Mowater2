<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Http\Requests\VehicleRequest;
use App\Models\Brand;
use App\Models\CarClass;
use App\Models\CarModel;
use App\Models\Color;
use App\Models\Country;
use App\Models\File;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class OrgVehicleController extends Controller
{
    private $vehicle;
    private $brand;
    private $carModel;
    private $carClass;
    private $country;
    private $color;

    public function __construct(Vehicle $vehicle, Brand $brand, CarModel $carModel, CarClass $carClass, Country $country, Color $color)
    {
        $this->middleware(['HasVehicles:read'])->only(['index', 'show']);
        $this->middleware(['HasVehicles:update'])->only('edit');
        $this->middleware(['HasVehicles:create'])->only('create');
        $this->middleware(['HasVehicles:delete'])->only('destroy');

        $this->brand = $brand;
        $this->carModel = $carModel;
        $this->carClass = $carClass;
        $this->country = $country;
        $this->color = $color;
        $this->vehicle = $vehicle;
    }

    public function index()
    {
        try {
            $record = getModelData();
            $vehicles = getModelData()->vehicles()->latest('id')->get();
            return view('organization.vehicles.index', compact('vehicles', 'record'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function create()
    {
        try {
            $record = getModelData();
            if ($record->getAttribute('brand_id')) {
                $brands = $this->brand->where('id', $record->brand_id)->get();
            } else {
                $brands = $this->brand->all();
            }
            $car_classes = $this->carClass->all();
            $car_models = $this->carModel->all();
            $countries = $this->country->all();
            $colors = $this->color->all();
            return view('organization.vehicles.create', compact('record', 'brands', 'car_models', 'car_classes', 'countries', 'colors'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function store(VehicleRequest $request)
    {
        try {
            $record = getModelData();

            if (!$request->has('availability'))
                $request->request->add(['availability' => 0]);
            else
                $request->request->add(['availability' => 1]);

            if (!$request->has('active'))
                $request->request->add(['active' => 0]);
            else
                $request->request->add(['active' => 1]);

            if (!$request->has('active_number_of_views'))
                $request->request->add(['active_number_of_views' => 0]);
            else
                $request->request->add(['active_number_of_views' => 1]);


            if ($request->is_new == 1)
                $requested_data = $request->except(['traveled_distance', 'traveled_distance_type', 'in_bahrain', 'country_id',
                    'guarantee', 'guarantee_month', 'guarantee_year', 'insurance', 'insurance_month', 'insurance_year', 'coverage_type',
                    'selling_by_plate', 'number_plate', 'price_is_negotiable', 'location']);
            else
                $requested_data = $request->except(['colors', 'images', 'threeDFiles']);

            DB::beginTransaction();
            $vehcile = $record->vehicles()->create($requested_data);

            if ($request->images) {
                for ($i = 0; $i < count($request->colors); $i++) {
                    $color_code = $request->colors[$i];

                    if (array_key_exists($i, $request->images)) {
                        $images = $request->images[$i];
                        foreach ($images as $image) {
                            $file = $image->store('vehicles/images');
                            $vehcile->files()->create([
                                'path' => $file,
                                'color_id' => $color_code,
                                'type' => 'vehicle'
                            ]);
                        }
                    }
                }
            }
            if ($request->has('threeDFile')) {
                $threeDFile = $request->threeDFile;
                $fileName = time() . '.' . $threeDFile->getClientOriginalExtension();
                $threeFile = $threeDFile->storeAs('vehicles/images', $fileName, 'uploads');
                $vehcile->files()->create([
                    'path' => $threeFile,
                    'color_id' => $color_code,
                    'type' => 'vehicle_3D'
                ]);
            }
            DB::commit();
            return redirect()->route('organization.vehicles.index')->with(['success' => __('message.created_successfully')]);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function show($id)
    {
        try {
            $record = getModelData();
            $vehicle = getModelData()->vehicles()->find($id);
            $keys = array_keys($vehicle->vehicleProperties());
            return view('organization.vehicles.show', compact('vehicle', 'record', 'keys'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function edit($id)
    {
        try {
            $record = getModelData();
            if ($record->getAttribute('brand_id')) {
                $brands = $this->brand->where('id', $record->brand_id)->get();
            } else {
                $brands = $this->brand->all();
            }
            $car_classes = $this->carClass->all();

            $vehicle = $this->vehicle->find($id);
            $car_models = $this->carModel->where('brand_id', $vehicle->brand_id)->get();

            $images = $vehicle->files()->where('type','!=','vehicle_3D')->get();
            $grouped_images = $images->groupby('color_id');
            $threeD_file = $vehicle->files()->where('type','vehicle_3D')->first();

            $countries = $this->country->all();
            $colors = $this->color->all();

            return view('organization.vehicles.edit', compact('record','threeD_file', 'grouped_images', 'vehicle', 'countries', 'colors', 'brands', 'car_models', 'car_classes'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function update(VehicleRequest $request, $id)
    {
        try {
            $vehcile = $this->vehicle->find($id);

            if (!$request->has('availability'))
                $request->request->add(['availability' => 0]);
            else
                $request->request->add(['availability' => 1]);

            if (!$request->has('active'))
                $request->request->add(['active' => 0]);
            else
                $request->request->add(['active' => 1]);

            if (!$request->has('active_number_of_views'))
                $request->request->add(['active_number_of_views' => 0]);
            else
                $request->request->add(['active_number_of_views' => 1]);

            if ($request->is_new == 1)
                $requested_data = $request->except(['traveled_distance', 'traveled_distance_type', 'in_bahrain', 'country_id',
                    'guarantee', 'guarantee_month', 'guarantee_year', 'insurance', 'insurance_month', 'insurance_year', 'coverage_type',
                    'selling_by_plate', 'number_plate', 'price_is_negotiable', 'location']);
            else
                $requested_data = $request->except(['colors', 'images', 'threeDFiles']);

            if ($request->images) {
                for ($i = 0; $i < count($request->colors); $i++) {
                    $color_code = $request->colors[$i];

                    if (array_key_exists($i, $request->images)) {
                        $images = $request->images[$i];
                        foreach ($images as $image) {
                            $file = $image->store('vehicles/images');
                            $vehcile->files()->create([
                                'path' => $file,
                                'color_id' => $color_code,
                                'type' => 'vehicle'
                            ]);
                        }

                    }
                }
            }

            if ($request->has('threeDFile')) {
                $threeDFile = $request->threeDFile;
                $fileName = time() . '.' . $threeDFile->getClientOriginalExtension();
                $threeFile = $threeDFile->storeAs('vehicles/images', $fileName, 'uploads');
                $vehcile->files()->create([
                    'path' => $threeFile,
                    'type' => 'vehicle_3D'
                ]);
            }

            if (request()->has('deleted_images')) {
                foreach (request()->deleted_images as $image) {
                    $img = File::findOrFail($image);
                    Storage::delete($img->getRawOriginal('path'));
                    $img->delete();
                }
            }

            $vehcile->update($requested_data);
            return redirect()->route('organization.vehicles.index')->with(['success' => __('message.updated_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function destroy($id)
    {
        try {
            $vehicle = $this->vehicle->find($id);
            $vehicle->deleteImages();
            $vehicle->delete();
            return redirect()->route('organization.vehicles.index')->with(['success' => __('message.deleted_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }
}
