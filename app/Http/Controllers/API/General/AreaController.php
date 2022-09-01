<?php

namespace App\Http\Controllers\API\General;

use App\Http\Controllers\Controller;
use App\Models\Area;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AreaController extends Controller
{
    public function index(){
        $areas = Area::with(['city' => function($query){
            $query->selection()->get();
        }])->selection()->search()->latest('id')->paginate(PAGINATION_COUNT);
        return responseJson(1, 'success', $areas);
    }

    public function show(Request $request){
        $validator = Validator::make($request->all(),[
            'id' => 'required|exists:areas,id',
        ]);
        if ($validator->fails())
            return responseJson(0, $validator->errors());
        $area = Area::with(['city' => function($query){
            $query->selection()->get();
        }])->selection()->find($request->id);
        return responseJson(1, 'success', $area);
    }
}
