<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrganizationRequest;
use App\Models\Agency;
use App\Models\Brand;
use App\Models\CarClass;
use App\Models\CarModel;
use App\Models\Country;
use App\Models\City;
use App\Models\Area;
use App\Models\Category;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Builder;

class OrgDataController extends Controller
{

    public function index()
    {
        $user = auth()->guard('web')->user();
        $organization = $user->organizable;
        $countries = Country::all();

        try {
            $user = auth()->guard('web')->user();
            $organization = $user->organizable;
            $countries = Country::all();
            $brands = Brand::get();
            $car_classes = CarClass::all();

            if (isset($organization->car_model_id)) {
                $organization->car_model;
            }
            $class = get_class($organization);

            if ($class == 'App\Models\Branch') {
                $branch = $organization;
                $main_org = $branch->branchable;
                $categories = Category::whereHas('section', function (Builder $query) use ($main_org) {

                    $query->where('ref_name', $main_org->ref_name);

                })->get();

                $country_id = $branch->city ? $branch->city->country_id : null;

                $cities = City::where('country_id', $country_id)->get();

                $areas = Area::where('city_id', $branch->city_id)->get();

                return view('organization.general_org.branch_index', compact('branch', 'countries', 'categories', 'cities', 'areas', 'brands', 'car_classes'));
            } else {

                $record = $organization;
                if ($class == 'App\Models\DrivingTrainer') {
                    $hour_price = Section::where('ref_name', 'DrivingTrainer')->first()->reservation_cost;
                    return view('organization.general_org.index', compact('record', 'countries', 'brands', 'car_classes', 'hour_price'));

                }
                if ($class == 'App\Models\DeliveryMan') {
                    $section = Section::where('ref_name', 'DeliveryMan')->first();
                    $categories = $section->categories;
                    return view('organization.general_org.index', compact('record', 'countries', 'brands', 'car_classes', 'categories'));

                }
                return view('organization.general_org.index', compact('record', 'countries', 'brands', 'car_classes'));
            }


        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);

        }
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {

    }


    public function show($id)
    {
        $user = auth()->guard('web')->user();

        $model_type = $user->organizable_type;
        $model_id = $user->organizable_id;
        $id = $model_id;
        $model = new $model_type;
        $show_organization = $model->find($id);
        if ($show_organization->getAttribute('brand_id')) {
            $show_organization->brand;
        }
        if ($show_organization->getAttribute('address_en','address_ar')) {
            $show_organization->makeVisible('address_en','address_ar');
        }

        $show_organization->makeVisible('name_en', 'name_ar', 'description_en', 'description_ar');
        if ($show_organization->files) {
            $show_organization->files;
        }
        if ($show_organization->file) {
            $show_organization->file;
        }
        if (isset($show_organization->car_model_id)) {
            $show_organization->car_model;
        }

        $data = compact('show_organization', 'model_type');
        return response()->json(['status' => true, 'data' => $data]);
    }


    public function edit($id)
    {
        //
    }


    public function update(OrganizationRequest $request, $id)
    {
        $user = auth()->guard('web')->user();

        $model_type = $user->organizable_type;
        $model = new $model_type;


        $record = $model->find($id);
//        if (!$request->has('active'))
//            $request->request->add(['active' => 0]);
//        else
//            $request->request->add(['active' => 1]);

        if (!$request->has('reservation_active'))
            $request->request->add(['reservation_active' => 0]);
        else
            $request->request->add(['reservation_active' => 1]);

        if (!$request->has('delivery_active'))
            $request->request->add(['delivery_active' => 0]);
        else
            $request->request->add(['delivery_active' => 1]);

        if (!$request->has('available'))
            $request->request->add(['available' => 0]);
        else
            $request->request->add(['available' => 1]);

        if (!$request->has('reservation_availability'))
            $request->request->add(['reservation_availability' => 0]);
        else
            $request->request->add(['reservation_availability' => 1]);

        if (!$request->has('delivery_availability'))
            $request->request->add(['delivery_availability' => 0]);
        else
            $request->request->add(['delivery_availability' => 1]);

        $request_data = $request->except(['_token', 'logo','fuel_types']);
        if ($request->has('fuel_types')) {
            $request_data['fuel_types'] = implode(",", $request->fuel_types);;
        }
        if ($request->has('logo')) {
            $image_path = public_path('uploads/');

            if (File::exists($image_path . $record->getRawOriginal('logo'))) {
                File::delete($image_path . $record->getRawOriginal('logo'));
            }

            $image = $request->logo->store('logos');
            $request_data['logo'] = $image;
        }
        if ($request->has('birth_date')) {
            $request_data['birth_date'] = date('Y-m-d', strtotime($request->birth_date));

        }
        if ($request->has('profile_picture')) {
            $image_path = public_path('uploads/');

            if (File::exists($image_path . $record->getRawOriginal('profile_picture'))) {
                File::delete($image_path . $record->getRawOriginal('profile_picture'));
            }

            $image = $request->profile_picture->store('profile_pictures');
            $request_data['profile_picture'] = $image;
        }
        if ($request->has('image')) {
//            $image_path = public_path('uploads/');
            $request_data['license_certificate'] = 1;
            $record->updateImage();
        }

        $record->update($request_data);
//      return $request_data;

        if ($record) {
            return redirect()->route('organization.organizations.index')->with(['success' => __('message.updated_successfully')]);
        } else {

            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }


    }

    public function update_branch_data(Request $request)
    {
        $rules = [
            'name_en' => 'required|max:255',
            'name_ar' => 'required|max:255',
            'address_en' => 'required',
            'address_ar' => 'required',
            'city_id' => 'nullable|exists:cities,id',
            'area_id' => 'nullable|exists:areas,id',
            'category_id' => 'required|exists:categories,id',
            'longitude' => 'max:255',
            'latitude' => 'max:255',
        ];

        $request->validate($rules);


        if (!$request->has('availability'))
            $request->request->add(['availability' => 0]);
        else
            $request->request->add(['availability' => 1]);

        if (!$request->has('reservation_availability'))
            $request->request->add(['reservation_availability' => 0]);
        else
            $request->request->add(['reservation_availability' => 1]);

        if (!$request->has('delivery_availability'))
            $request->request->add(['delivery_availability' => 0]);
        else
            $request->request->add(['delivery_availability' => 1]);

        $user = auth()->guard('web')->user();
        $branch = $user->organizable;

        if (!$request->area_id) {
            $request->merge(['area_id' => null]);
        }

        $branch->update($request->all());


        return back()->with('success', __('message.updated_successfully'));
    }


    public function destroy($id)
    {
        //
    }
}
