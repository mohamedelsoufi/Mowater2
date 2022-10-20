<?php

namespace App\Http\Controllers\Dashboard\General;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminAdRequest;
use App\Models\Ad;
use App\Models\AdType;
use App\Models\Area;
use App\Models\City;
use App\Models\Country;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AdminAdController extends Controller
{
    private $model;
    private $country;
    private $city;
    private $area;

    public function __construct(Ad $model, Country $country, City $city, Area $area)
    {
        $this->middleware(['permission:read-ads'])->only('index');
        $this->middleware(['permission:create-ads'])->only('create');
        $this->middleware(['permission:update-ads'])->only('edit');
        $this->middleware(['permission:delete-ads'])->only('delete');

        $this->model = $model;
        $this->country = $country;
        $this->city = $city;
        $this->area = $area;
    }

    public function index()
    {
        try {
            $ads = $this->model->latest('id')->get();
            return view('admin.general.ads.index', compact('ads'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function create()
    {
        try {
            $sections = Section::where('id','!=',4)->get();
            $ad_types = AdType::whereIn('id',[1,4])->get();
            $countries = $this->country->latest('id')->get();
            return view('admin.general.ads.create',compact('sections','ad_types','countries'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function store(AdminAdRequest $request)
    {
        try {
            if (!$request->has('active'))
                $request->request->add(['active' => 0]);
            else
                $request->request->add(['active' => 1]);

            if (!$request->has('active_number_of_views'))
                $request->request->add(['active_number_of_views' => 0]);
            else
                $request->request->add(['active_number_of_views' => 1]);

            $request_data = $request->except(['_token', 'image', 'ref_name', 'link', 'organization_id']);

            $request_data['created_by'] = auth('admin')->user()->email;
            $request_data['organizationable_type'] = 'App\\Models\\' . $request->ref_name;
            $request_data['organizationable_id'] = $request->organization_id;
            $request_data['link'] = $request->link;
            $request_data['start_date'] = date('Y-m-d H:i:s', strtotime($request->start_date));
            $request_data['end_date'] = date('Y-m-d H:i:s', strtotime($request->end_date));

            if ($request->has('image')) {
                $image = $request->image->store('ads');
                $request_data['image'] = $image;
            }

             $this->model->create($request_data);

            return redirect()->route('ads.index')->with(['success' => __('message.created_successfully')]);
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
            $ad = $this->getModelById($id);
            return view('admin.general.ads.show', compact('ad'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function edit($id)
    {
        try {
            $ad = $this->getModelById($id);
            $sections = Section::where('id','!=',4)->get();
            $ad_types = AdType::get();
            $countries = $this->country->latest('id')->get();
            return view('admin.general.ads.edit', compact('ad', 'sections', 'ad_types','countries'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function update(AdminAdRequest $request, $id)
    {
        try {
            $ad = $this->getModelById($id);

            if (!$request->has('active'))
                $request->request->add(['active' => 0]);
            else
                $request->request->add(['active' => 1]);

            if (!$request->has('active_number_of_views'))
                $request->request->add(['active_number_of_views' => 0]);
            else
                $request->request->add(['active_number_of_views' => 1]);

            $request_data = $request->except(['_token', 'image', 'ref_name', 'link', 'organization_id']);

            $request_data['created_by'] = auth('admin')->user()->email;
            $request_data['organizationable_type'] = 'App\\Models\\' . $request->ref_name;
            $request_data['organizationable_id'] = $request->organization_id;
            $request_data['link'] = $request->link;
            $request_data['start_date'] = date('Y-m-d H:i:s', strtotime($request->start_date));
            $request_data['end_date'] = date('Y-m-d H:i:s', strtotime($request->end_date));

            if ($request->ad_type_id != 4){
                $request_data['link'] = '';
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

            return redirect()->route('ads.index')->with(['success' => __('message.updated_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function destroy($id)
    {
        try {
            $ad = $this->getModelById($id);

            $image_path = public_path('uploads/');
            if (File::exists($image_path . $ad->getRawOriginal('image'))) {
                File::delete($image_path . $ad->getRawOriginal('image'));
            }
            $ad->delete();
            return redirect()->route('ads.index')->with(['success' => __('message.deleted_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function getOrgs($orgName){
        $class = 'App\\Models\\' . $orgName;
        $org = new $class;

        $organizations = $org->latest('id')->get();

        return response()->json(['status' => true, 'data' => $organizations]);
    }
}
