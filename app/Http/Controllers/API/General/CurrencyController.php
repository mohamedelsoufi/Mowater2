<?php

namespace App\Http\Controllers\API\General;

use App\Http\Controllers\Controller;
use App\Models\Color;
use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CurrencyController extends Controller
{
    public function index(){
        $currencies = Currency::selection()->search()->latest('id')->paginate(PAGINATION_COUNT);
        return responseJson(1, 'success', $currencies);
    }

    public function show(Request $request){
        $validator = Validator::make($request->all(),[
            'id' => 'required|exists:currencies,id',
        ]);
        if ($validator->fails())
            return responseJson(0, $validator->errors());
        $currency = Currency::find($request->id);
        return responseJson(1, 'success', $currency);
    }
}
