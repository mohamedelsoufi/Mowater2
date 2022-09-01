<?php

namespace App\Http\Controllers\Dashboard\VehicleDetails;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BrandRequest;
use App\Models\ManufactureCountry;
use Illuminate\Http\Request;
use App\Models\Brand;
use Illuminate\Support\Facades\File;

class BrandsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:read-brands'])->only('index');
        $this->middleware(['permission:create-brands'])->only('create');
        $this->middleware(['permission:update-brands'])->only('edit');
        $this->middleware(['permission:delete-brands'])->only('delete');
    }

    public function index()
    {
        try {
            $brands = Brand::latest('id')->get();
            $countries = ManufactureCountry::all();
            return view('admin.vehicle_details.brands.index', compact('brands', 'countries'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function show($id)
    {
        try {
            $brand = Brand::find($id);
            return view('admin.vehicle_details.brands.show', compact('brand'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function create()
    {
        try {
            $manufacture_countries = ManufactureCountry::active()->get();
            return view('admin.vehicle_details.brands.create', compact('manufacture_countries'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function store(BrandRequest $request)
    {
        try {
            if (!$request->has('active'))
                $request->request->add(['active' => 0]);
            else
                $request->request->add(['active' => 1]);

            $request_data = $request->except(['_token', 'logo']);

            if ($request->has('logo')) {
                $image = $request->logo->store('brands/logos');
                $request_data['logo'] = $image;
            }
            $brand = Brand::create($request_data);

            return redirect()->route('brands.index')->with(['success' => __('message.created_successfully')]);

        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function edit($id)
    {
        try {
            $brand = Brand::find($id);
            $manufacture_countries = ManufactureCountry::active()->get();
            return view('admin.vehicle_details.brands.edit', compact('manufacture_countries', 'brand'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function update(BrandRequest $request, $id)
    {
        try {
            $brand = Brand::find($id);
            if (!$request->has('active'))
                $request->request->add(['active' => 0]);
            else
                $request->request->add(['active' => 1]);

            $request_data = $request->except(['_token', 'logo']);

            if ($request->has('logo')) {
                $image_path = public_path('uploads/');

                if (File::exists($image_path . $brand->getRawOriginal('logo'))) {
                    File::delete($image_path . $brand->getRawOriginal('logo'));
                }

                $image = $request->logo->store('brands/logos');
                $request_data['logo'] = $image;
            }

            $update_brand = $brand->update($request_data);
            if ($update_brand) {
                return redirect()->route('brands.index')->with(['success' => __('message.updated_successfully')]);
            } else {
                return redirect()->route('brands.index')->with(['error' => __('message.something_wrong')]);
            }
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function destroy($id)
    {
        try {
            $brand = Brand::find($id);
            $image_path = public_path('uploads/');
            if (File::exists($image_path . $brand->getRawOriginal('logo'))) {
                File::delete($image_path . $brand->getRawOriginal('logo'));
            }
            $brand->delete();
            return redirect()->route('brands.index')->with(['success' => __('message.deleted_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }
}
