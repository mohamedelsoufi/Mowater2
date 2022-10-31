<?php


namespace App\Repositories\PaymentMethod;


use App\Models\PaymentMethod;

class PaymentMethodRepository implements PaymentMethodInterface
{
    public function getAll(){
        try {
            $payment_methods = PaymentMethod::all();
            return $payment_methods;
        }catch (\Exception $e){
            return responseJson(0,'error',$e->getMessage());
        }
    }

    public function getById($request){
        try {
            $payment_method = PaymentMethod::find($request->id);
            return $payment_method;
        }catch (\Exception $e){
            return responseJson(0,'error',$e->getMessage());
        }
    }
}
