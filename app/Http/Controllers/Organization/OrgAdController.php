<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdRequest;
use App\Models\AdType;
use App\Models\Area;
use App\Models\Contact;
use App\Models\Country;
use App\Models\City;
use App\Models\Ad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class OrgAdController extends Controller
{
    private $ad;
    private $ad_type;
    private $country;

    public function __construct(Ad $ad, AdType $ad_type, Country $country)
    {
        $this->middleware(['HasOrgAd:read'])->only(['index', 'show']);
        $this->middleware(['HasOrgAd:update'])->only('edit');
        $this->middleware(['HasOrgAd:create'])->only('create');
        $this->middleware(['HasOrgAd:delete'])->only('destroy');

        $this->ad = $ad;
        $this->ad_type = $ad_type;
        $this->country = $country;
    }

    public function index()
    {
        try {
            $record = getModelData();
            $ads = $record->ads()->latest('id')->get();
            return view('organization.ads.index', compact('ads', 'record'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function create()
    {
        try {
            $record = getModelData();
            $ad_types = $this->ad_type->all();
            $countries = $this->country->all();
            $modules = $this->getAdModuleType();
            return view('organization.ads.create', compact('record', 'ad_types', 'countries', 'modules'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    private function getAdModuleType()
    {
        $modules = [];
        if (method_exists(auth()->guard('web')->user()->organizable, 'vehicles'))
            $modules['App\\Models\\Vehicle'] = 'vehicles';
        if (method_exists(auth()->guard('web')->user()->organizable, 'products'))
            $modules['App\\Models\\Product'] = 'products';
        if (method_exists(auth()->guard('web')->user()->organizable, 'services'))
            $modules['App\\Models\\Service'] = 'services';
        if (method_exists(auth()->guard('web')->user()->organizable, 'accessories'))
            $modules['App\\Models\\Accessory'] = 'accessories';
        if (method_exists(auth()->guard('web')->user()->organizable, 'carWashServices'))
            $modules['App\\Models\\CarWashService'] = 'carWashServices';
        if (method_exists(auth()->guard('web')->user()->organizable, 'packages'))
            $modules['App\\Models\\InsuranceCompanyPackage'] = 'packages';
        if (method_exists(auth()->guard('web')->user()->organizable, 'brokerPackages'))
            $modules['App\\Models\\BrokerPackage'] = 'brokerPackages';
        if (method_exists(auth()->guard('web')->user()->organizable, 'miningCenterService'))
            $modules['App\\Models\\MiningCenterService'] = 'miningCenterService';
        if (method_exists(auth()->guard('web')->user()->organizable, 'rental_office_cars'))
            $modules['App\\Models\\RentalOfficeCar'] = 'rental_office_cars';
        if (method_exists(auth()->guard('web')->user()->organizable, 'special_numbers'))
            $modules['App\\Models\\SpecialNumber'] = 'special_numbers';
        if (method_exists(auth()->guard('web')->user()->organizable, 'inspectionCenterService'))
            $modules['App\\Models\\TechnicalInspectionCenterService'] = 'inspectionCenterService';
        if (method_exists(auth()->guard('web')->user()->organizable, 'tireExchangeService'))
            $modules['App\\Models\\TireExchangeCenterService'] = 'tireExchangeService';
        if (method_exists(auth()->guard('web')->user()->organizable, 'trafficServices'))
            $modules['App\\Models\\TrafficClearingService'] = 'trafficServices';

        return $modules;
    }

    public function getModule($relation)
    {
        try {
            $record = getModelData();
            $model_data = $record[$relation];
            if ($relation == 'vehicles') {
                foreach ($model_data as $model) {
                    $model['name'] = $model->name;
                }
            }
            $data = compact('model_data');
            return response()->json(['status' => true, 'data' => $data]);
        } catch (\Exception $e) {
            return responseJson(false, 'error', $e->getMessage());
        }
    }

    public function store(AdRequest $request)
    {
        try {
            $record = getModelData();
            if (!$request->has('active'))
                $request->request->add(['active' => 0]);
            else
                $request->request->add(['active' => 1]);

            if (!$request->has('active_number_of_views'))
                $request->request->add(['active_number_of_views' => 0]);
            else
                $request->request->add(['active_number_of_views' => 1]);

            $request_data = $request->except(['_token', 'image', 'link']);

            $request_data['created_by'] = auth('web')->user()->email;
            $request_data['status'] = 'pending';
            $request_data['start_date'] = date('Y-m-d H:i:s', strtotime($request->start_date));
            $request_data['end_date'] = date('Y-m-d H:i:s', strtotime($request->end_date));

            if ($request->ad_type_id == 4){
                $request_data['module_type'] = null;
                $request_data['module_id'] = null;
                $request_data['link'] = $request->link;
            }else{
                $request_data['link'] = null;
            }

            if ($request->has('image')) {
                $image = $request->image->store('ads');
                $request_data['image'] = $image;
            }

            $record->ads()->create($request_data);

            return redirect()->route('organization.ads.index')->with(['success' => __('message.created_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function show($id)
    {
        try {
            $record = getModelData();
            $ad = $this->ad->find($id);
            return view('organization.ads.show', compact('record', 'ad'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function edit($id)
    {
        try {
            $record = getModelData();
            $ad = $this->ad->find($id);
            $ad_types = $this->ad_type->all();
            $countries = $this->country->all();
            $modules = $this->getAdModuleType();
            return view('organization.ads.edit', compact('ad', 'record', 'ad_types', 'countries', 'modules'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function update(AdRequest $request, $id)
    {
        try {
            $ad = $this->ad->find($id);

            if (!$request->has('active'))
                $request->request->add(['active' => 0]);
            else
                $request->request->add(['active' => 1]);

            if (!$request->has('active_number_of_views'))
                $request->request->add(['active_number_of_views' => 0]);
            else
                $request->request->add(['active_number_of_views' => 1]);

            $request_data = $request->except(['_token', 'image', 'link']);

            $request_data['created_by'] = auth('web')->user()->email;
            $request_data['status'] = 'pending';
            $request_data['start_date'] = date('Y-m-d H:i:s', strtotime($request->start_date));
            $request_data['end_date'] = date('Y-m-d H:i:s', strtotime($request->end_date));
            if ($request->ad_type_id == 4){
                $request_data['module_type'] = null;
                $request_data['module_id'] = null;
                $request_data['link'] = $request->link;
            }else{
                $request_data['link'] = null;
            }


            if ($request->has('image')) {
                $image_path = public_path('uploads/');

                if (File::exists($image_path . $ad->getRawOriginal('image'))) {
                    File::delete($image_path . $ad->getRawOriginal('image'));
                }

                $image = $request->image->store('ads');
                $request_data['image'] = $image;
            }

            $ad->update($request_data);

            return redirect()->route('organization.ads.index')->with(['success' => __('message.updated_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function destroy($id)
    {
        try {
            $ad = $this->ad->find($id);
            $image_path = public_path('uploads/');
            if (File::exists($image_path . $ad->getRawOriginal('image'))) {
                File::delete($image_path . $ad->getRawOriginal('image'));
            }
            $ad->delete();
            return redirect()->route('organization.ads.index')->with(['success' => __('message.deleted_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }
}
