<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdRequest;
use App\Models\AdType;
use App\Models\Area;
use App\Models\Country;
use App\Models\City;
use App\Models\Ad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class OrgAdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->guard('web')->user();
        $model_type = $user->organizable_type;
        $model_id = $user->organizable_id;
        $model = new $model_type;
        $record = $model->find($model_id);
        $ads = $record->ads;
        $countries = Country::all();
        $cities = City::all();
        $areas = Area::all();
        $ad_types = AdType::all();
        return view('organization.ads.index', compact('ads', 'ad_types', 'countries', 'cities', 'areas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdRequest $request)
    {
        if (!$request->has('available'))
            $request->request->add(['available' => 0]);
        else
            $request->request->add(['available' => 1]);
        if (!$request->has('active'))
            $request->request->add(['active' => 1]);
        else
            $request->request->add(['active' => 0]);

        $request_data = $request->except(['images']);
        $user = auth()->guard('web')->user();
        $model_type = $user->organizable_type;
        $model_id = $user->organizable_id;
        $model = new $model_type;
        $record = $model->find($model_id);
        $ad = $record->ads()->create($request_data);
        if ($request->has('images')) {
            $ad->uploadImages();
        }
        if ($ad)
            return redirect()->route('organization.ads.index')->with(['success' => __('message.created_successfully')]);
        else
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $show_ad = Ad::find($id);
        $countries = Country::all();
        $cities = City::all();
        $areas = Area::all();
        $ad_types = AdType::all();

//        $data = compact('show_ad');
//        return response()->json(['status' => true, 'data' => $data]);
        return view('organization.ads.update', compact('show_ad', 'ad_types', 'countries', 'cities', 'areas'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $show_ad = Ad::find($id);
        $data = compact('show_ad');
        return response()->json(['status' => true, 'data' => $data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdRequest $request, $id)
    {
        $ad = Ad::find($id);
        if ($request->has('images') || $request->has('deleted_images')) {
            $ad->updateImages();
        }
        $ad->update($request->all());
        if ($ad) {
            return redirect()->route('organization.ads.index')->with(['success' => __('message.updated_successfully')]);
        } else {

            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ad = Ad::find($id);

        $ad->deleteImages();

        $ad->delete();
        return redirect()->route('organization.ads.index')->with(['success' => __('message.deleted_successfully')]);

    }
}
