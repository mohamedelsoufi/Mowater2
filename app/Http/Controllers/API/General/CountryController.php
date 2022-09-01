<?php

namespace App\Http\Controllers\API\General;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CountryController extends Controller
{
    public function index(){
        $countries = Country::with('currency')->selection()->latest('id')->paginate(PAGINATION_COUNT);
        return responseJson(1, 'success', $countries);
    }

    public function show(Request $request){
        $validator = Validator::make($request->all(),[
            'id' => 'required|exists:countries,id',
        ]);
        if ($validator->fails())
            return responseJson(0, $validator->errors());
        $country = Country::with('currency')->selection()->find($request->id);
        return responseJson(1, 'success', $country);
    }
}
