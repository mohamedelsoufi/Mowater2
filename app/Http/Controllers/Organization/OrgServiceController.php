<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Service;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Http\Requests\ServiceRequest;
use Illuminate\Support\Facades\File;

class OrgServiceController extends Controller
{

    public function index()
    {
        $user = auth()->guard('web')->user();
        $model_type = $user->organizable_type;
        $model_id = $user->organizable_id;
        $model = new $model_type;
        $record = $model->find($model_id);
        $services = $record->services()->latest()->get();
        $categories = Category::where('ref_name', 'services')->get();
        return view('organization.services.index', compact('services', 'categories'));
    }


    public function create()
    {
        $categories = Category::where('ref_name', 'services')->get();
        return view('organization.services.create', compact('categories'));
    }


    public function store(Request $request)
    {
        if (!$request->has('available'))
            $request->request->add(['available' => 0]);
        else
            $request->request->add(['available' => 1]);


        $user = auth()->guard('web')->user();
        $model_type = $user->organizable_type;
        $model_id = $user->organizable_id;
        $model = new $model_type;
        $record = $model->find($model_id);
        $service = $record->services()->create($request->all());
        if ($request->has('images')) {
            $service->uploadServiceImages();
//            return $product;
        }
        if ($service)
            return redirect()->route('organization.services.index')->with(['success' => __('message.created_successfully')]);
        else
            return redirect()->back()->with(['error' => __('message.something_wrong')]);

    }


    public function show($id)
    {
        $show_service = Service::find($id);
        $show_service->makeVisible('name_en', 'name_ar', 'description_en', 'description_ar');
        $data = compact('show_service');
        return response()->json(['status' => true, 'data' => $data]);
    }


    public function edit($id)
    {
        $show_service = Service::find($id);
        $show_service->makeVisible('name_en', 'name_ar', 'description_en', 'description_ar');
        $categories = Category::where('ref_name', 'services')->get();
        return view('organization.services.update', compact('show_service', 'categories'));
    }

    public function update(ServiceRequest $request, $id)
    {

        $service = Service::find($id);
        if (!$request->has('available'))
            $request->request->add(['available' => 0]);
        else
            $request->request->add(['available' => 1]);


        $request_data = $request->except(['images']);
        if ($request->has('images') || $request->has('deleted_images')) {

            $request->merge([
                'folder_name' => 'services'
            ]);

            return $request;
            $service->updateImages();
        }

        $service->update($request_data);

        if ($service) {
            return redirect()->route('organization.services.index')->with(['success' => __('message.updated_successfully')]);
        } else {

            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }


    public function destroy($id)
    {
        $service = Service::find($id);
        $service->deleteImages();
        $service->delete();
        return redirect()->route('organization.services.index')->with(['success' => __('message.deleted_successfully')]);

    }
}
