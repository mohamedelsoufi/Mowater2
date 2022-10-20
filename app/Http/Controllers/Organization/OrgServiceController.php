<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;

use App\Models\Category;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Requests\ServiceRequest;

class OrgServiceController extends Controller
{
    private $service;
    private $category;

    public function __construct(Service $service, Category $category)

    {
        $this->middleware(['HasOrgService:read'])->only(['index', 'show']);
        $this->middleware(['HasOrgService:update'])->only('edit');
        $this->middleware(['HasOrgService:create'])->only('create');
        $this->middleware(['HasOrgService:delete'])->only('destroy');
        $this->service = $service;
        $this->category = $category;
    }

    public function index()
    {
        try {
            $record = getModelData();
            $services = $record->services()->latest('id')->get();
            return view('organization.services.index', compact('services', 'record'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function create()
    {
        try {
            $record = getModelData();
            $categories = $this->category->where('ref_name', 'services')->latest('id')->get();
            return view('organization.services.create', compact('record', 'categories'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function store(ServiceRequest $request)
    {
        try {
            if (!$request->has('active'))
                $request->request->add(['active' => 0]);
            else
                $request->request->add(['active' => 1]);

            if (!$request->has('available'))
                $request->request->add(['available' => 0]);
            else
                $request->request->add(['available' => 1]);

            if (!$request->has('active_number_of_views'))
                $request->request->add(['active_number_of_views' => 0]);
            else
                $request->request->add(['active_number_of_views' => 1]);

            $request_data = $request->except(['_token', 'images']);
            $request_data['created_by'] = auth('web')->user()->email;
            $record = getModelData();

            $service = $record->services()->create($request_data);
            if ($request->has('images')) {
                request()->merge([
                    'folder_name' => 'services'
                ]);
                $service->uploadImages();
            }
            return redirect()->route('organization.services.index')->with(['success' => __('message.created_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        try {
            $service = $this->service->find($id);
            $record = getModelData();
            return view('organization.services.show', compact('service', 'record'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function edit($id)
    {
        try {
            $service = $this->service->find($id);
            $record = getModelData();
            $categories = $this->category->where('ref_name', 'services')->latest('id')->get();
            return view('organization.services.edit', compact( 'record', 'categories', 'service'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function update(ServiceRequest $request, $id)
    {
        try {
            $service = $this->service->find($id);
            if (!$request->has('active'))
                $request->request->add(['active' => 0]);
            else
                $request->request->add(['active' => 1]);

            if (!$request->has('available'))
                $request->request->add(['available' => 0]);
            else
                $request->request->add(['available' => 1]);

            if (!$request->has('active_number_of_views'))
                $request->request->add(['active_number_of_views' => 0]);
            else
                $request->request->add(['active_number_of_views' => 1]);

            request()->merge([
                'folder_name' => 'services'
            ]);

            $request_data = $request->except(['_token', 'images', 'deleted_images', 'folder_name']);
            $request_data['created_by'] = auth('web')->user()->email;

            if ($request->has('images') || $request->has('deleted_images')) {
                $service->updateImages();
            }
            $service->update($request_data);
            return redirect()->route('organization.services.index')->with(['success' => __('message.updated_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function destroy($id)
    {
        try {
            $service = $this->service->find($id);
            $service->deleteImages();
            $service->delete();
            return redirect()->route('organization.services.index')->with(['success' => __('message.deleted_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }
}
