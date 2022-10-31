<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Http\Requests\DayOffRequest;
use App\Models\DayOff;
use Illuminate\Http\Request;

class OrgDayOffController extends Controller
{

    private $dayOff;

    public function __construct(DayOff $dayOff)

    {
        $this->middleware(['HasOrgDayOff:read'])->only(['index', 'show']);
        $this->middleware(['HasOrgDayOff:update'])->only('edit');
        $this->middleware(['HasOrgDayOff:create'])->only('create');
        $this->middleware(['HasOrgDayOff:delete'])->only('destroy');
        $this->dayOff = $dayOff;

    }

    public function index()
    {
        try {
            $record = getModelData();
            $days_off = $record->day_offs;

            return view('organization.daysOff.index', compact('record', 'days_off'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function create()
    {
        try {
            $record = getModelData();
            return view('organization.daysOff.create', compact('record'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function store(DayOffRequest $request)
    {
        try {
            $organization = getModelData();
            $request_data = $request->except('token');
            $request_data['created_by'] = auth()->user()->email;
            $organization->day_offs()->create($request_data);

            return redirect()->route('organization.days-off.index')->with('success', __('message.created_successfully'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function show($id)
    {
        try {
            $day_off = $this->dayOff->find($id);
            $record = getModelData();
            return view('organization.daysOff.show', compact('day_off', 'record'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function edit($id)
    {
        try {
            $day_off = $this->dayOff->find($id);
            $record = getModelData();
            return view('organization.daysOff.edit', compact('day_off', 'record'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function update(DayOffRequest $request, $id)
    {
        try {
            $day_off = $this->dayOff->find($id);
            $request_data = $request->except('token');
            $request_data['created_by'] = auth('web')->user()->email;
            $day_off->update($request_data);
            return redirect()->route('organization.days-off.index')->with('success', __('message.updated_successfully'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function destroy($id)
    {
        try {
            $day_off = $this->dayOff->find($id);
            $day_off->delete();
            return redirect()->route('organization.days-off.index')->with('success', __('message.deleted_successfully'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }
}
