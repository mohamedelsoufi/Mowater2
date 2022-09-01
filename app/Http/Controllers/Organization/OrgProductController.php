<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\CarModel;
use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class OrgProductController extends Controller
{
    public function index()
    {
        $user = auth()->guard('web')->user();
        $model_type = $user->organizable_type;
        $model_id = $user->organizable_id;
        $model = new $model_type;
        $record = $model->find($model_id);
        $products = $record->products()->latest()->get();

        return view('organization.products.index', compact('products','model_type'));

    }

    public function create()
    {
        $user = auth()->guard('web')->user();
        $model_type = $user->organizable_type;
//        $model_id = $user->organizable_id;
//        $model = new $model_type;
//        $record = $model->find($model_id);
////        return $model_type;
//        if ($model_type == 'App\Models\Agency') {
//            $car_models = CarModel::where('brand_id', $record->brand_id)->get();
//        } else
//            $car_models = CarModel::all();
//        $categories = Category::all();
        $organiztion = $user->organizable;

        $car_models = CarModel::where(function ($query) use ($organiztion) {
            if ($organiztion->brand) {
                $query->where('brand_id', $organiztion->brand_id);
            }
        })->get();
        $categories = Category::where('ref_name', 'products')->get();
        $sub_categories = SubCategory::all();
        return view('organization.products.create', compact('car_models', 'categories','sub_categories','model_type'));
    }

    public function store(ProductRequest $request)
    {
//        return $request;
        if (!$request->has('available'))
            $request->request->add(['available' => 0]);
        else
            $request->request->add(['available' => 1]);

        $request_data = $request->except(['images']);
        $user = auth()->guard('web')->user();
        $model_type = $user->organizable_type;
        $model_id = $user->organizable_id;
        $model = new $model_type;
        $record = $model->find($model_id);

        $product = $record->products()->create($request_data);
        if ($request->has('images')) {
            $product->uploadImages();
//            return $product;
        }
        if ($request->has('car_models')) {
            $car_models = array_keys($request->car_models);
            if ($request->has('manufacturing_years')) {
                $manufacturing_years = $request->manufacturing_years;
//                return $manufacturing_years;
                $i = 0;
                foreach ($request->car_models as $car_model) {
                    $product->car_models()->attach($car_model, [
                        'manufacturing_years' => $manufacturing_years[$car_models[$i]],
                    ]);
                    $i = $i + 1;
                }
            } else
                return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
        if ($product)
            return redirect()->route('organization.products.index')->with(['success' => __('message.created_successfully')]);
        else
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
    }

    public function show($id)
    {
        $show_product = Product::find($id);
        $show_product->makeVisible('name_en', 'name_ar', 'description_en', 'description_ar');
        $user = auth()->guard('web')->user();

        $model_type = $user->organizable_type;
//        $model_id = $user->organizable_id;
//        $model = new $model_type;
//        $record = $model->find($model_id);
////        return $model_type;
//        if ($model_type == 'App\Models\Agency') {
//            $car_models = CarModel::where('brand_id', $record->brand_id)->get();
//        } else
//            $car_models = CarModel::all();
//        $categories = Category::all();

        $organiztion = $user->organizable;

        $car_models = CarModel::where(function ($query) use ($organiztion) {
            if ($organiztion->brand) {
                $query->where('brand_id', $organiztion->brand_id);
            }
        })->get();
        $categories = Category::where('ref_name', 'products')->get();
        $sub_categories = SubCategory::all();
        return view('organization.products.update', compact('sub_categories','show_product', 'car_models','model_type', 'categories'));
    }

    public function edit($id)
    {
        $show_product = Product::find($id);
        $data = compact('show_product');
        return response()->json(['status' => true, 'data' => $data]);

    }

    public function update(ProductRequest $request, $id)
    {
//        return $request;
        $product = Product::find($id);
        if (!$request->has('available'))
            $request->request->add(['available' => 0]);
        else
            $request->request->add(['available' => 1]);
        if (!$request->has('active'))
            $request->request->add(['active' => 1]);
        else
            $request->request->add(['active' => 0]);
        $request_data = $request->except(['images']);
        if ($product->productable_type == 'App\\Models\\Agency')
            $request_data['type'] = 'original';
            $request_data['is_new'] = 1;
            $request_data['type'] = 'excellent';

        if ($request->has('images') || $request->has('deleted_images')) {

            $request->merge([
                'folder_name' => 'products'
            ]);
            $product->updateImages();
        }
        if ($request->has('car_models')) {
            $manufacturing_years = $request->manufacturing_years;
            $car_models = array_keys($request->car_models);
            $car_model_data = [];
            $i = 0;
//            return $car_models;
            foreach ($request->car_models as $car_model) {
                $car_model_data[$car_model] = ['manufacturing_years' => $manufacturing_years[$car_models[$i]]];
                $i = $i + 1;
            }
            if ($car_model_data)
                $product->car_models()->sync($car_model_data);
        }
//        return $request_data;
        $product->update($request_data);
        if ($product)
            return redirect()->route('organization.products.index')->with(['success' => __('message.updated_successfully')]);
        else
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        $product->deleteImages();
        $product->delete();
        return redirect()->route('organization.products.index')->with(['success' => __('message.deleted_successfully')]);

    }

    public function sub_category($id)
    {
        $category = Category::find($id);
        $sub_categories = $category->sub_categories;

        $data = compact('sub_categories');
        return response()->json(['status' => true, 'data'=>$data]);
    }
}
