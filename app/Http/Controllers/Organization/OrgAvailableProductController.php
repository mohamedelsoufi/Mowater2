<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Http\Requests\AvailableProductRequest;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Category;
use App\Models\Country;
use App\Models\City;
use App\Models\Area;

class OrgAvailableProductController extends Controller
{
    public function __construct()
    {
        $this->middleware(['HasAvailableProduct:read'])->only(['index', 'show']);
        $this->middleware(['HasAvailableProduct:update'])->only('edit');
    }

    public function index()
    {
        try {
            $record = getModelData();
            $availableProducts = $record->available_products()->latest('id')->get();
            return view('organization.availableProducts.index', compact('record', 'availableProducts'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function show($id)
    {
        try {
            $record = getModelData();
            $availableProduct = $record->available_products->find($id);
            return view('organization.availableProducts.show', compact('record', 'availableProduct'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' =>$e->getMessage()]);
        }
    }

    public function edit()
    {
        try {
            $record = getModelData();
            $org = $record->branchable;
            $products = $org->products()->active()->available()->latest('id')->get();
            $availableProducts = $record->available_products()->pluck('usable_id')->toArray();
            return view('organization.availableProducts.edit', compact('record', 'products','availableProducts'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }


    public function update(AvailableProductRequest $request)
    {
        try {
            $record = getModelData();

            $record->available_products()->sync($request->available_products);

            return redirect()->route('organization.available-products.index')->with('success', __('message.updated_successfully'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

}
