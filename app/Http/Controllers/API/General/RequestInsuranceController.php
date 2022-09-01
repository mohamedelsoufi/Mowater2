<?php

namespace App\Http\Controllers\API\General;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\QuotationRequest;
use App\Models\Broker;
use App\Models\InsuranceCompany;
use App\Models\RequestInsurance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RequestInsuranceController extends Controller
{
    public function quotationRequest(QuotationRequest $request)
    {
        $user = getAuthAPIUser();
        $request['user_id'] = $user->id;
        $requested_features = $request->features;
        $feature_array = array_map('intval',explode(',',$requested_features));
        $insurance_request = RequestInsurance::create($request->all());
        if (isset($insurance_request)) {
            $insurance_companies = InsuranceCompany::get();
            $brokers = Broker::get();
            if (isset($insurance_companies)) {
                foreach ($insurance_companies as $insurance_company) {
                   $check = $insurance_company->features()->whereIn('usable_id', $feature_array)->get();
                   if (!empty($check))
                        $insurance_request->insurance_companies()->attach($insurance_company->id, [
                            'request_insurance_id' => $insurance_request->id
                        ]);
                }
            }
            if (count($brokers) > 0) {
                foreach ($brokers as $broker) {
                    $check_broker = $broker->features()->whereIn('usable_id', $feature_array)->get();
                   if (!empty($check_broker))
                       $insurance_request->brokers()->attach($broker->id, [
                           'request_insurance_id' => $insurance_request->id
                       ]);
                }
            }
            return responseJson(1, 'success');
        }
    }

}
