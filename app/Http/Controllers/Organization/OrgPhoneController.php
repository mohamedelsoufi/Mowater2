<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Http\Requests\PhoneRequest;
use App\Models\Phone;
use Illuminate\Http\Request;

class OrgPhoneController extends Controller
{
    private $phone;

    public function __construct(Phone $phone)

    {
        $this->middleware(['HasOrgPhone:read'])->only(['index', 'show']);
        $this->middleware(['HasOrgPhone:update'])->only('edit');
        $this->middleware(['HasOrgPhone:create'])->only('create');
        $this->middleware(['HasOrgPhone:delete'])->only('destroy');
        $this->phone = $phone;

    }

    public function index()
    {
        try {
            $record = getModelData();
            $phones = $record->phones;
            return view('organization.phones.index', compact('record', 'phones'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function create()
    {
        try {
            $record = getModelData();
            return view('organization.phones.create', compact('record'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function store(PhoneRequest $request)
    {
        try {
            $record = getModelData();

            $request_data = $request->except('token');
            $request_data['created_by'] = auth('web')->user()->email;

            $record->phones()->create($request_data);
            return redirect()->route('organization.phones.index')->with('success', __('message.created_successfully'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function show($id)
    {
        try {
            $record = getModelData();
            $phone = $this->phone->find($id);
            return view('organization.phones.show', compact('record', 'phone'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function edit($id)
    {
        try {
            $record = getModelData();
            $phone = $this->phone->find($id);
            return view('organization.phones.edit', compact('record', 'phone'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function update(PhoneRequest $request, $id)
    {
        try {
            $phone = $this->phone->find($id);

            $request_data = $request->except('token');
            $request_data['created_by'] = auth('web')->user()->email;

            $phone->update($request_data);
            return redirect()->route('organization.phones.index')->with('success', __('message.updated_successfully'));

        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function destroy($id)
    {
        try {
            $phone = $this->phone->find($id);
            $phone->delete();
            return redirect()->route('organization.phones.index')->with('success', __('message.deleted_successfully'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }
}
