<?php

namespace App\Http\Resources\Delivery;

use Illuminate\Http\Resources\Json\JsonResource;

class ShowDeliveryCategoriesResourse extends JsonResource
{
    public function toArray($request)
    {
        $after_discount = 0;
        if ($this->pivot->discount != null) {
            $discount_type = $this->pivot->discount_type;
            $percentage_value = ((100 - $this->pivot->discount) / 100);
            if ($discount_type == 'percentage') {
                 $after_discount = $this->pivot->price * $percentage_value;
            } else {
                 $after_discount = $this->pivot->price - $this->pivot->discount;

            }
        }


        return [
            "id" => $this->id,
            "name" => $this->name,
            "price" => $this->pivot->price,
            "discount" => $this->pivot->discount,
            "discount_type" => $this->pivot->discount_type,
            "price_after_discount" => $after_discount,
        ];
    }
}
