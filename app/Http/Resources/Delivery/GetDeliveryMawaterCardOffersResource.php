<?php

namespace App\Http\Resources\Delivery;

use Illuminate\Http\Resources\Json\JsonResource;

class GetDeliveryMawaterCardOffersResource extends JsonResource
{
    public function toArray($request)
    {
        $data["id"] = $this->id;
        $data["delivery_man_id"] = $this->delivery_man_id;
        $data["delivery_man"] = $this->delivery_men->name;
        $data["category_id"] = $this->category_id;
        $data["category_id"] = $this->categories->name;
        $data["price"] = $this->price;
        $data["card_discount_value"] = $this->card_discount_value;
        $data["card_price_after_discount"] = $this->card_price_after_discount;
        $data["card_number_of_uses_times"] = $this->card_number_of_uses_times;
        $data["notes"] = $this->notes;

        return $data;
    }
}
