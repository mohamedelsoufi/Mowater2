<?php

namespace App\Http\Controllers\API\General;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\ShowSectionRequest;
use App\Http\Resources\Sections\GetSectionsResource;
use App\Models\Ad;
use App\Models\Section;
use App\Models\Slider;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function index()
    {
        try {
            $sections = Section::search()->where('section_id', null)->paginate(PAGINATION_COUNT);
            if (empty($sections))
                return responseJson(0,__('message.no_result'));
            return responseJson(1, 'success', GetSectionsResource::collection($sections)->response()->getData(true));
        }catch (\Exception $e){
            return responseJson(0,'error',$e->getMessage());
        }
    }

    public function show(ShowSectionRequest $request)
    {
        try {
            $section = Section::find($request->id);
            if (empty($section))
                return responseJson(0,__('message.no_result'));
            return responseJson(1, 'success', new GetSectionsResource($section));
        }catch (\Exception $e){
            return responseJson(0,'error',$e->getMessage());
        }
    }
}
