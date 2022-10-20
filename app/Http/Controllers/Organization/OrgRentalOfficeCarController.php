<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Http\Requests\RentalOfficeCarRequest;
use App\Http\Requests\RentalPropertyRequest;
use App\Models\CarModel;
use App\Models\Color;
use App\Models\Country;
use App\Models\RentalOfficeCar;
use App\Models\RentalProperty;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\CarClass;
use Illuminate\Support\Facades\DB;

class OrgRentalOfficeCarController extends Controller
{
    private $rentalCar;
    private $property;
    private $brand;
    private $carModel;
    private $carClass;
    private $country;
    private $color;

    public function __construct(RentalOfficeCar $rentalCar, RentalProperty $property, Brand $brand, CarModel $carModel, CarClass $carClass, Country $country, Color $color)
    {
        $this->middleware(['HasOrgRentalOfficeCar:read'])->only(['index', 'show']);
        $this->middleware(['HasOrgRentalOfficeCar:update'])->only('edit');
        $this->middleware(['HasOrgRentalOfficeCar:create'])->only('create');
        $this->middleware(['HasOrgRentalOfficeCar:delete'])->only('destroy');
        $this->middleware(['HasOrgCarProperty:read'])->only(['getProperties', 'showProperty']);
        $this->middleware(['HasOrgCarProperty:create'])->only('createProperty');
        $this->middleware(['HasOrgCarProperty:update'])->only('editProperty');
        $this->middleware(['HasOrgCarProperty:delete'])->only('destroyProperty');

        $this->brand = $brand;
        $this->carModel = $carModel;
        $this->carClass = $carClass;
        $this->country = $country;
        $this->color = $color;
        $this->rentalCar = $rentalCar;
        $this->property = $property;
    }

    public function index()
    {
        try {
            $record = getModelData();
            $cars = getModelData()->rental_office_cars()->latest('id')->get();
            return view('organization.rentalOfficeCars.index', compact('cars', 'record'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function create()
    {
        try {
            $record = getModelData();
            $brands = $this->brand->all();
            $car_classes = $this->carClass->all();
            $colors = $this->color->all();
            $properties = $this->property->latest('id')->get();
            return view('organization.rentalOfficeCars.create', compact('record', 'properties', 'brands', 'car_classes', 'colors'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function store(RentalOfficeCarRequest $request)
    {
        try {
            $record = getModelData();

            if (!$request->has('available'))
                $request->request->add(['available' => 0]);
            else
                $request->request->add(['available' => 1]);

            if (!$request->has('active'))
                $request->request->add(['active' => 0]);
            else
                $request->request->add(['active' => 1]);

            if (!$request->has('active_number_of_views'))
                $request->request->add(['active_number_of_views' => 0]);
            else
                $request->request->add(['active_number_of_views' => 1]);

            $requested_data = $request->except(['images', 'cars_properties']);

            DB::beginTransaction();
            $car = $record->rental_office_cars()->create($requested_data);

            if ($request->has('cars_properties')) {
                $car->properties()->attach($request->cars_properties);
            }

            if ($request->has('images')) {
                request()->merge([
                    'folder_name' => 'rental_offices/cars'
                ]);
                $car->uploadImages();
            }

            DB::commit();
            return redirect()->route('organization.rental-office-cars.index')->with(['success' => __('message.created_successfully')]);
        } catch
        (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        try {
            $record = getModelData();
            $car = getModelData()->rental_office_cars()->find($id);
            $properties = $car->properties;
            return view('organization.rentalOfficeCars.show', compact('car', 'record', 'properties'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function edit($id)
    {
        try {
            $record = getModelData();
            $car = $record->rental_office_cars()->find($id);
            $brands = $this->brand->all();
            $car_classes = $this->carClass->all();
            $colors = $this->color->all();
            $properties = $this->property->latest('id')->get();
            $car_properties = $car->properties()->pluck('rental_property_id')->toArray();
            return view('organization.rentalOfficeCars.edit', compact('car','car_properties','record', 'properties', 'brands', 'car_classes', 'colors'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function update(RentalOfficeCarRequest $request, $id)
    {
        try {
            $record = getModelData();
            $car = $record->rental_office_cars()->find($id);

            if (!$request->has('available'))
                $request->request->add(['available' => 0]);
            else
                $request->request->add(['available' => 1]);

            if (!$request->has('active'))
                $request->request->add(['active' => 0]);
            else
                $request->request->add(['active' => 1]);

            if (!$request->has('active_number_of_views'))
                $request->request->add(['active_number_of_views' => 0]);
            else
                $request->request->add(['active_number_of_views' => 1]);

            $requested_data = $request->except(['images', 'cars_properties','deleted_images']);

            DB::beginTransaction();
            $car->update($requested_data);

            if ($request->has('cars_properties')) {
                $car->properties()->sync($request->cars_properties);
            }

            if ($request->has('images')) {
                request()->merge([
                    'folder_name' => 'rental_offices/cars'
                ]);
               $car->updateImages();
            }

            DB::commit();
            return redirect()->route('organization.rental-office-cars.index')->with(['success' => __('message.created_successfully')]);
        } catch
        (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        try {
            $car = $this->rentalCar->find($id);
            $car->deleteImages();
            $car->delete();
            return redirect()->route('organization.rental-office-cars.index')->with(['success' => __('message.deleted_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function getProperties()
    {
        try {
            $record = getModelData();
            $properties = $this->property->latest('id')->get();
            return view('organization.rentalCarProperties.index', compact('properties', 'record'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function showProperty($id)
    {
        try {
            $record = getModelData();
            $property = $this->property->find($id);
            return view('organization.rentalCarProperties.show', compact('property', 'record'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function createProperty()
    {
        try {
            $record = getModelData();
            return view('organization.rentalCarProperties.create', compact('record'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function storeProperty(RentalPropertyRequest $request)
    {
        try {
            $this->property->create($request->except('_token'));
            return redirect()->route('organization.rental-cars-properties.index')->with(['success' => __('message.created_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function editProperty($id)
    {
        try {
            $record = getModelData();
            $property = $this->property->find($id);
            return view('organization.rentalCarProperties.edit', compact('property', 'record'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function updateProperty(RentalPropertyRequest $request, $id)
    {
        try {
            $property = $this->property->find($id);
            $property->update($request->except('_token'));
            return redirect()->route('organization.rental-cars-properties.index')->with(['success' => __('message.updated_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function destroyProperty($id)
    {
        try {
            $property = $this->property->find($id);
            $property->delete();
            return redirect()->route('organization.rental-cars-properties.index')->with(['success' => __('message.deleted_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }
}
