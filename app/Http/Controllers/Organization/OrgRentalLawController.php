<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Http\Requests\RentalLawRequest;
use App\Models\RentalLaw;
use Illuminate\Http\Request;

class OrgRentalLawController extends Controller
{
    public function __construct()
    {
        $this->middleware(['HasOrgRentalLaw:read'])->only(['index', 'show']);
        $this->middleware(['HasOrgRentalLaw:update'])->only('edit');
        $this->middleware(['HasOrgRentalLaw:create'])->only('create');
        $this->middleware(['HasOrgRentalLaw:delete'])->only('destroy');
    }

    public function index()
    {
        try {
            $record = getModelData();
            $laws = getModelData()->rental_laws()->latest('id')->get();
            return view('organization.rentalLaws.index', compact('laws', 'record'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function create()
    {
        try {
            $record = getModelData();
            return view('organization.rentalLaws.create', compact('record'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function store(RentalLawRequest $request)
    {
        try {
            $record = getModelData();
            $record->rental_laws()->create($request->except('_token'));
            return redirect()->route('organization.rental-laws.index')->with(['success' => __('message.created_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        try {
            $record = getModelData();
            $law = $record->rental_laws()->find($id);
            return view('organization.rentalLaws.show', compact('law', 'record'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function edit($id)
    {
        try {
            $record = getModelData();
            $law = $record->rental_laws()->find($id);
            return view('organization.rentalLaws.edit', compact('law', 'record'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function update(RentalLawRequest $request, $id)
    {
        try {
            $record = getModelData();
            $law = $record->rental_laws()->find($id);
            $law->update($request->except('_token'));
            return redirect()->route('organization.rental-laws.index')->with(['success' => __('message.updated_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        try {
            $record = getModelData();
            $law = $record->rental_laws()->find($id);
            $law->delete();
            return redirect()->route('organization.rental-laws.index')->with(['success' => __('message.deleted_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }
}
