<?php

namespace App\Http\Controllers\API\General;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\ShowPaymentMethodRequest;
use App\Http\Resources\PaymentMethods\GetPaymentMethodsResource;
use App\Repositories\PaymentMethod\PaymentMethodInterface;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    private $payment_method;

    public function __construct(PaymentMethodInterface $payment_method)
    {
        $this->payment_method = $payment_method;
    }

    public function index(){
        return GetPaymentMethodsResource::collection($this->payment_method->getAll());
    }

    public function show(ShowPaymentMethodRequest $request){
        return new GetPaymentMethodsResource($this->payment_method->getById($request));
    }
}
