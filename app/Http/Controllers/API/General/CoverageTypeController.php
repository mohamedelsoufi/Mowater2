<?php

namespace App\Http\Controllers\API\General;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\CoverageTypeRequest;
use App\Http\Resources\CoverageTypes\GetCoverageTypesResource;
use App\Models\CoverageType;

class CoverageTypeController extends Controller
{
    public function index()
    {
        try {
            $coverage_types = CoverageType::paginate(PAGINATION_COUNT);
            return responseJson(1, "success", GetCoverageTypesResource::collection($coverage_types)->response()->getData(true));
        } catch (\Exception $e) {
            return responseJson(0, "error", $e->getMessage());
        }
    }

    public function show(CoverageTypeRequest $request)
    {
        try {
            $coverage_type = CoverageType::find($request->id);
            return responseJson(1, "success", new GetCoverageTypesResource($coverage_type));
        } catch (\Exception $e) {
            return responseJson(0, "error", $e->getMessage());
        }
    }
}
