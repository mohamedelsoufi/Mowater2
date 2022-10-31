<?php

namespace App\Http\Controllers\API\General;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index(){
        $brands = Brand::selection()->active()->search()->latest('id')->paginate(PAGINATION_COUNT);
        if ($brands->isEmpty())
            return responseJson(0, __('message.no_result'));
        return responseJson(1 , 'success', $brands);
    }
}
