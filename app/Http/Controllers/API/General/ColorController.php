<?php

namespace App\Http\Controllers\API\General;

use App\Http\Controllers\Controller;
use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ColorController extends Controller
{
    public function index(){
        $colors = Color::paginate(PAGINATION_COUNT);
        return responseJson(1, 'success', $colors);
    }

    public function show(Request $request){
        $validator = Validator::make($request->all(),[
            'id' => 'required|exists:colors,id',
        ]);
        if ($validator->fails())
            return responseJson(0, $validator->errors());
        $color = Color::find($request->id);
        return responseJson(1, 'success', $color);
    }
}
