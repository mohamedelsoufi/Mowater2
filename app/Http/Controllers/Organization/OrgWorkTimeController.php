<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Http\Requests\WorkTimeRequest;
use App\Models\WorkTime;
use Illuminate\Http\Request;

class OrgWorkTimeController extends Controller
{
    private $workTimes;

    public function __construct(WorkTime $workTimes)
    {
        $this->middleware(['HasOrgWorkTime:read'])->only(['index', 'show']);
        $this->middleware(['HasOrgWorkTime:update'])->only('edit');

        $this->workTimes = $workTimes;
    }

    public function index()
    {
        try {
            $record = getModelData();
            $work_time = $record->work_time;
            return view('organization.workTimes.index', compact('record', 'work_time'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function edit()
    {
        try {
            $record = getModelData();
            $work_time = $record->work_time;

            return view('organization.workTimes.edit', compact('record', 'work_time'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }


    public function update(WorkTimeRequest $request)
    {
        try {
            $organization = getModelData();
            $work_time = $organization->work_time;

            $request->merge([
                'days' => implode(",", $request->work_days)
            ]);

            if ($work_time) {
                $work_time->update($request->all());
            } else {
                $organization->work_time()->create($request->all());
            }

            return redirect()->route('organization.work-times.index');
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

}
