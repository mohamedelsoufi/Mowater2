<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Models\RequestProduct;
use App\Models\User;
use Illuminate\Http\Request;

class OrgProductsRequestsController extends Controller
{
    public function index()
    {
        $user = auth()->guard('web')->user();
        $model_type = $user->organizable_type;
        $model_id = $user->organizable_id;
        $model = new $model_type;
        $record = $model->find($model_id);
        $products_requests = $record->request_product_organizations;
//        return count($products_requests);
        return view('organization.products_requests.index', compact('products_requests'));
    }

    public function show($id)
    {
        $user = auth()->guard('web')->user();
        $model_type = $user->organizable_type;
        $model_id = $user->organizable_id;
        $model = new $model_type;
        $record = $model->find($model_id);
        $product_request = $record->request_product_organizations->where('id', $id)->first();

        $user = User::find($product_request->user_id);
        return view('organization.products_requests.show', compact('product_request', 'user'));
    }

    public function reply($id)
    {
        $user = auth()->guard('web')->user();
        $model_type = $user->organizable_type;
        $model_id = $user->organizable_id;
        $model = new $model_type;
        $record = $model->find($model_id);
        $product_request = $record->request_product_organizations->where('id', $id)->first();
//        return $products_request;
        return view('organization.products_requests.update', compact('product_request'));
    }

    public function send_reply(Request $request)
    {
//        return $request;
        $user = auth()->guard('web')->user();
        $model_type = $user->organizable_type;
        $model_id = $user->organizable_id;
        $model = new $model_type;
        $record = $model->find($model_id);
        $product_request = $record->request_product_organizations->where('id', $request->id)->first();
        $product_request->pivot->status = "replied";
        $product_request->pivot->price = $request->price;
        $product_request->pivot->save();
        return view('organization.products_requests.update', compact('product_request'));
    }
}
