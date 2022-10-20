<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Brand;
use App\Models\CarClass;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class OrgProductController extends Controller
{
    private $product;
    private $brand;
    private $carClass;
    private $category;

    public function __construct(Product $product, Brand $brand, CarClass $carClass, Category $category)

    {
        $this->middleware(['HasOrgProduct:read'])->only(['index', 'show']);
        $this->middleware(['HasOrgProduct:update'])->only('edit');
        $this->middleware(['HasOrgProduct:create'])->only('create');
        $this->middleware(['HasOrgProduct:delete'])->only('destroy');
        $this->product = $product;
        $this->brand = $brand;
        $this->carClass = $carClass;
        $this->category = $category;
    }

    public function index()
    {
        try {
            $record = getModelData();
            $products = $record->products()->latest('id')->get();
            return view('organization.products.index', compact('products', 'record'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function create()
    {
        try {
            $record = getModelData();
            if ($record->getAttribute('brand_id')) {
                $brands = $this->brand->where('id', $record->brand_id)->get();
            } else {
                $brands = $this->brand->latest('id')->get();
            }
            $car_classes = $this->carClass->latest('id')->get();
            $categories = $this->category->where('ref_name', 'products')->latest('id')->get();
            return view('organization.products.create', compact('brands', 'record', 'car_classes', 'categories'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function store(ProductRequest $request)
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

            $product = $record->products()->create($request_data);
            if ($request->has('images')) {
                request()->merge([
                    'folder_name' => 'products'
                ]);
                $product->uploadImages();
            }
            return redirect()->route('organization.products.index')->with(['success' => __('message.created_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function show($id)
    {
        try {
            $product = $this->product->find($id);
            $record = getModelData();
            return view('organization.products.show', compact('product', 'record'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function edit($id)
    {
        try {
            $product = $this->product->find($id);
            $record = getModelData();
            if ($record->getAttribute('brand_id')) {
                $brands = $this->brand->where('id', $record->brand_id)->get();
            } else {
                $brands = $this->brand->latest('id')->get();
            }
            $car_classes = $this->carClass->latest('id')->get();
            $categories = $this->category->where('ref_name', 'products')->latest('id')->get();
            return view('organization.products.edit', compact('brands', 'record', 'car_classes', 'categories', 'product'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function update(ProductRequest $request, $id)
    {
        try {
            $product = $this->product->find($id);
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
                'folder_name' => 'products'
            ]);

            $request_data = $request->except(['_token', 'images', 'deleted_images', 'folder_name']);
            $request_data['created_by'] = auth('web')->user()->email;

            if ($request->has('images') || $request->has('deleted_images')) {
                 $product->updateImages();
            }
            $product->update($request_data);
            return redirect()->route('organization.products.index')->with(['success' => __('message.updated_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function destroy($id)
    {
        try {
            $product = $this->product->find($id);
            $product->deleteImages();
            $product->delete();
            return redirect()->route('organization.products.index')->with(['success' => __('message.deleted_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function sub_category($id)
    {
        $category = Category::find($id);
        $sub_categories = $category->sub_categories;

        $data = compact('sub_categories');
        return response()->json(['status' => true, 'data' => $data]);
    }
}
