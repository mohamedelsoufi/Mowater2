<?php

namespace App\Http\Controllers\Dashboard\General;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminAdTypeRequest;
use App\Models\AdType;
use Illuminate\Http\Request;

class AdminAdTypeController extends Controller
{
    private $model;

    public function __construct(AdType $model)
    {
        $this->middleware(['permission:read-ad_types'])->only('index');
        $this->middleware(['permission:update-ad_types'])->only('edit');

        $this->model = $model;
    }

    public function index()
    {
        try {
            $ad_types = $this->model->get();
            return view('admin.general.ads.adTypes.index', compact('ad_types'));
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
            $ad_type = $this->getModelById($id);
            return view('admin.general.ads.adTypes.show', compact('ad_type'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function edit($id)
    {
        try {
            $ad_type = $this->getModelById($id);
            return view('admin.general.ads.adTypes.edit', compact('ad_type'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function update(AdminAdTypeRequest $request, $id)
    {
        try {
            $ad_type = $this->getModelById($id);

            $request_data = $request->only(['price']);

            $request_data['created_by'] = auth('admin')->user()->email;


            $ad_type->update($request_data);

            return redirect()->route('ad-types.index')->with(['success' => __('message.updated_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }
}
