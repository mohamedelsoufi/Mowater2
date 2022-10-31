<?php

namespace App\Http\Resources\TrafficClearingOffices;

use Illuminate\Http\Resources\Json\JsonResource;

class GetTrafficClearingOffersResource extends JsonResource
{
    public function toArray($request)
    {
        $data = [];

        $data["id"] = $this->id;
        $data["traffic_office_id"] = $this->traffic_clearing_office_id;
        $data["traffic_office"] = $this->traffic_office->name;
        $data["traffic_clearing_service_id"] = $this->traffic_clearing_service_id;
        $data["traffic_clearing_service"] = $this->traffic_service->name;
        $data["fees"] = $this->fees;
        $data["price"] = $this->price;
        $data["is_mowater_card"] = $this->is_mowater_card;
        if ($this->is_mowater_card === true) {
            $data["card_discount_value"] = $this->card_discount_value;
            $data["card_price_after_discount"] = $this->card_price_after_discount;
            $data["card_number_of_uses_times"] = $this->card_number_of_uses_times;
            $data["notes"] = $this->notes;
        } else {
            $data["discount_type"] = $this->discount_type;
            $data["discount"] = $this->discount;
            $data["price_after_discount"] = $this->price_after_discount;
        }

        return $data;
    }
}
