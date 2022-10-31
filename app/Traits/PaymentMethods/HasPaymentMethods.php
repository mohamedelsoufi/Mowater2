<?php


namespace App\Traits\PaymentMethods;

trait HasPaymentMethods
{
    public function payment_methods()
    {
        return $this->morphToMany('App\Models\PaymentMethod', 'model', 'available_payment_methods');
    }

}
