<?php

namespace App\Http\Controllers\API\General;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\OrderPiece;
//use Dotenv\Validator;
use App\Models\Product;
use App\Models\RequestProduct;
use App\Models\Scrap;
use App\Models\SparePart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function request_product(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'brand_id' => 'required|exists:brands',
            'car_model' => 'required',
            'manufacturing_year' => 'required',
            'category_id' => 'required|exists:categories,id',
            'type' => 'required',
            'is_new' => 'required',
            'vehicle_number' => 'required'
        ]);
        if ($validator->fails())
            return responseJson(0, $validator->errors());
        $request_product = $request->all();
        $request_product['user_id'] = auth('api')->user()->id;
        $products = Product::where('category_id', $request->category_id)->get();
        $request_product_save = RequestProduct::create($request_product);
        $i = 0;
//        return responseJson(1, 'suc', $products);
        if (isset($products)) {
            foreach ($products as $product) {

                if ($product->is_new == $request->is_new && $product->type == $request->type) {
                    if ($product->productable_type == 'App\\Models\\Scrap') {
                        $request_product_save->scraps()->attach($product->productable_id, [
                            'request_product_id' => $request_product_save->id,
                        ]);
                        $i += 1;
                    } else if ($product->productable_type == 'App\\Models\\SparePart') {
                        $request_product_save->spare_parts()->attach($product->productable_id, [
                            'request_product_id' => $request_product_save->id,
                        ]);
                        $i += 1;
                    }
                }
            }
        }
        if ($i > 0) {
            return responseJson(1, 'success');
        }
        return responseJson(0, __('message.no_product_found'));
    }

    public function get_requests()
    {
        $user = auth('api')->user();
        $requests = $user->request_products()->paginate(PAGINATION_COUNT);
        return responseJson(1, 'success', $requests);
    }

    public function get_requests_replies(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'request_product_id' => 'required|exists:request_products,id',
        ]);
        if ($validator->fails())
            return responseJson(0, $validator->errors());
        $user = auth('api')->user();
        $replies = $user->replies->where('status', 'replied')->paginate(PAGINATION_COUNT);
        return responseJson(1, 'success', $replies);
    }

    public function get_products_categories()
    {
        $categories = Category::where('ref_name', 'products')->paginate(PAGINATION_COUNT);
        return responseJson(1, 'success', $categories);

    }

    public function show(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:products,id',
        ]);
        if ($validator->fails())
            return responseJson(0, $validator->errors());

        try {
            $product = Product::with('category','sub_category','car_models','files')->selection()->active()->find($request->id);

            //update number of views start
            updateNumberOfViews($product);
            //update number of views end

            return responseJson(1, 'success', $product);
        }catch (\Exception $e){
            return responseJson(0, 'error', $e->getMessage());
        }

    }
}
