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
use App\Models\MainVehicle;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OrgVehicleController extends Controller
{

    public function index()
    {
        $user = auth()->guard('web')->user();

        $model_type = $user->organizable_type;
        $model_id = $user->organizable_id;
        $model = new $model_type;
        $record = $model->find($model_id);
        $vehicles = $record->vehicles()->latest('id')->get();


        $organization = $model->find($model_id);
        $brands = Brand::all();
        $car_classes = CarClass::all();
        $car_models = CarModel::all();

        return view('organization.vehicles.index', compact('vehicles', 'organization', 'brands', 'car_models', 'car_classes'));

    }


    public function create()
    {
        $user = auth()->guard('web')->user();

        $model_type = $user->organizable_type;
        $model_id = $user->organizable_id;
        $model = new $model_type;
        $record = $model->find($model_id);


        if ($record->getAttribute('brand_id')) {
            $brands = Brand::where('id', $record->brand_id)->get();
        } else {
            $brands = Brand::all();
        }

        $car_classes = CarClass::all();
        $car_models = CarModel::all();
        $countries = Country::all();
        $colors = Color::all();

        return view('organization.vehicles.create', compact('brands', 'car_models', 'car_classes', 'countries', 'colors'));
    }


    public function store(VehicleRequest $request)
    {
//        return $request;
        $user = auth()->guard('web')->user();

        $model_type = $user->organizable_type;
        $model_id = $user->organizable_id;
        $model = new $model_type;
        $record = $model->find($model_id);


        if ($request->is_new == 1)
            $requested_data = $request->except(['traveled_distance', 'traveled_distance_type', 'in_bahrain', 'country_id',
                'guarantee', 'guarantee_month', 'guarantee_year', 'insurance', 'insurance_month', 'insurance_year', 'coverage_type',
                'selling_by_plate', 'number_plate', 'price_is_negotiable', 'location']);
        else
            $requested_data = $request->except(['colors', 'images','threeDFiles']);

        $vehciles = $record->vehicles()->create($requested_data);


        if ($request->images) {
            for ($i = 0; $i < count($request->colors); $i++) {
                $color_code = $request->colors[$i];

                if (array_key_exists($i, $request->images)) {
                    $images = $request->images[$i];
                    foreach ($images as $image) {
                        $file = $image->store('vehicles/images');
                        $vehciles->files()->create([
                            'path' => $file,
                            'color_id' => $color_code,
                            'type' => 'vehicle'
                        ]);
                    }
                }
                if (array_key_exists($i, $request->threeDFiles)) {
                    $threeDFiles = $request->threeDFiles[$i];
                    foreach ($threeDFiles as $threeDFile) {
                        $fileName = time() . '.' . $threeDFile->getClientOriginalExtension();
                        $threeFile = $threeDFile->storeAs('vehicles/images', $fileName, 'uploads');
                        $vehciles->files()->create([
                            'path' => $threeFile,
                            'color_id' => $color_code,
                            'type' => 'vehicle_3D'
                        ]);
                    }
                }
            }
        }

        if ($vehciles) {
            return redirect()->route('organization.vehicles.index')->with(['success' => __('message.created_successfully')]);
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
        $show_vehicle = $organization->vehicles()->with('brand', 'car_model', 'car_class')->find($id);
//        $show_vehicle = $vehicle->find($id);
        $data = compact('show_vehicle');
        return response()->json(['status' => true, 'data' => $data]);
    }


    public function edit($id)
    {
        $user = auth()->guard('web')->user();

        $model_type = $user->organizable_type;
        $model_id = $user->organizable_id;
        $model = new $model_type;
        $record = $model->find($model_id);
        if ($record->getAttribute('brand_id')) {
            $brands = Brand::where('id', $record->brand_id)->get();
        } else {
            $brands = Brand::all();
        }
        $car_classes = CarClass::all();

        $vehicle = Vehicle::find($id);
        $car_models = CarModel::where('brand_id', $vehicle->brand_id)->get();

        $images = $vehicle->files;
        $grouped_images = $images->groupby('color_id');


        $countries = Country::all();
        $colors = Color::all();

        return view('organization.vehicles.edit', compact('grouped_images', 'vehicle', 'countries', 'colors', 'brands', 'car_models', 'car_classes'));
    }


    public function update(VehicleRequest $request, $id)
    {
//return $request;
        $vehcile = Vehicle::find($id);

        if ($request->is_new == 1)
            $requested_data = $request->except(['traveled_distance', 'traveled_distance_type', 'in_bahrain', 'country_id',
                'guarantee', 'guarantee_month', 'guarantee_year', 'insurance', 'insurance_month', 'insurance_year', 'coverage_type',
                'selling_by_plate', 'number_plate', 'price_is_negotiable', 'location']);
        else
            $requested_data = $request->except(['colors', 'images','threeDFiles']);


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

        if ($request->threeDFiles) {
            for ($i = 0; $i < count($request->Dcolors); $i++) {
                $color_code = $request->Dcolors[$i];

                if (array_key_exists($i, $request->threeDFiles)) {
                    $threeDFiles = $request->threeDFiles[$i];
                    foreach ($threeDFiles as $threeDFile) {
                        $fileName = time() . '.' . $threeDFile->getClientOriginalExtension();
                        $threeFile = $threeDFile->storeAs('vehicles/images', $fileName, 'uploads');
                        $vehcile->files()->create([
                            'path' => $threeFile,
                            'color_id' => $color_code,
                            'type' => 'vehicle_3D'
                        ]);
                    }
                }

            }
        }

        if (request()->has('deleted_images')) {
            foreach (request()->deleted_images as $image) {
                $img = File::findOrFail($image);
                Storage::delete($img->getRawOriginal('path'));
                $img->delete();
            }
        }

        $update_vehicle = $vehcile->update($requested_data);

        if ($update_vehicle) {
            return redirect()->route('organization.vehicles.index')->with(['success' => __('message.updated_successfully')]);
        } else {

            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }

    }


    public function destroy($id)
    {
        $vehicle = Vehicle::find($id);

        $vehicle->deleteImages();
        $vehicle->delete();
        return redirect()->route('organization.vehicles.index')->with(['success' => __('message.deleted_successfully')]);
    }
}
