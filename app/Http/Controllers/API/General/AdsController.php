<?php

namespace App\Http\Controllers\API\General;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\ShowAdRequest;
use App\Http\Resources\Ads\GetAdsResource;
use App\Models\Ad;
use App\Models\AdType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdsController extends Controller
{
    public function index()
    {
        try {
            $ads = Ad::search()->where('status', 'approved')->where('end_date', '>', Carbon::now()->format('Y-m-d H:i:s'))->orderBy(AdType::select('priority')->whereColumn('ad_types.id', 'ads.ad_type_id'), 'desc'
            )->paginate(3);
            if (empty($ads))
                return responseJson(0, __('message.no_result'));
            return responseJson(1, 'success', GetAdsResource::collection($ads)->response()->getData(true));
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function show_ad(ShowAdRequest $request)
    {
        try {
            $ad = Ad::find($request->id);
            if (empty($ad))
                return responseJson(0, __('message.no_result'));
            //update number of views start
            updateNumberOfViews($ad);
            //update number of views end
            return responseJson(1, 'success', new GetAdsResource($ad));
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }
}
