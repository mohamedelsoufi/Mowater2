<?php

namespace App\Http\Controllers\API\Organizations;

use App\Http\Controllers\Controller;
use App\Http\Resources\Garages\GetCategoriesForGarageResource;
use App\Models\Section;

class GarageCategoriesController extends Controller
{
    public function index()
    {
        try {
            $section = Section::where('ref_name', 'Garage')->first();
            if ($section->categories->isEmpty()) {
                return responseJson(0, __('message.No_Categories_found'));
            }
            $data = $section->categories()->paginate(PAGINATION_COUNT);
            if (empty($data))
                return responseJson(0, __('message.no_result'));
            return responseJson(1, 'success', GetCategoriesForGarageResource::collection($data)->response()->getData(true));
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }
}
