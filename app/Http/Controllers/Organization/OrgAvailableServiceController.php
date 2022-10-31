<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Http\Requests\AvailableServiceRequest;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Category;
use App\Models\Country;
use App\Models\City;
use App\Models\Area;

class OrgAvailableServiceController extends Controller
{
    public function __construct()
    {
        $this->middleware(['HasAvailableService:read'])->only(['index', 'show']);
        $this->middleware(['HasAvailableService:update'])->only('edit');
    }

    public function index()
    {
        try {
            $record = getModelData();
            $availableServices = $record->available_services()->latest('id')->get();
            return view('organization.availableServices.index', compact('record', 'availableServices'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function show($id)
    {
        try {
            $record = getModelData();
            $availableService = $record->available_services->find($id);
            return view('organization.availableServices.show', compact('record', 'availableService'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' =>$e->getMessage()]);
        }
    }

    public function edit()
    {
        try {
            $record = getModelData();
            $org = $record->branchable;
            $services = $org->services()->active()->available()->latest('id')->get();
            $availableServices = $record->available_services()->pluck('usable_id')->toArray();
            return view('organization.availableServices.edit', compact('record', 'services','availableServices'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }


    public function update(AvailableServiceRequest $request)
    {
        try {
            $record = getModelData();

            $record->available_services()->sync($request->available_services);

            return redirect()->route('organization.available-services.index')->with('success', __('message.updated_successfully'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

}
