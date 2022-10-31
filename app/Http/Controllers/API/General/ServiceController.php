<?php

namespace App\Http\Controllers\API\General;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{
    public function index(){
        try {
            $services = Service::selection()->active()->latest()->paginate(PAGINATION_COUNT);
            return responseJson(1, 'success', $services);
        }catch (\Exception $e){
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function show(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:products,id',
        ]);
        if ($validator->fails())
            return responseJson(0, $validator->errors());

        try {
            $service = Service::with('category','files')->selection()->active()->find($request->id);

            //update number of views start
            updateNumberOfViews($service);
            //update number of views end

            return responseJson(1, 'success', $service);
        }catch (\Exception $e){
            return responseJson(0, 'error', $e->getMessage());
        }

    }
}
