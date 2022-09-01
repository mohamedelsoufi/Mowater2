<?php

namespace App\Http\Resources\TrafficClearingOffices;

use Illuminate\Http\Resources\Json\JsonResource;

class GetTrafficClearingOfficeMawaterOffersResource extends JsonResource
{
    public function toArray($request)
    {

        return [
            "id" => $this->id,
            "traffic_clearing_service_id" => $this->traffic_clearing_service_id,
            "service" => new GetServicesResource($this->traffic_service),
            "traffic_clearing_office_id" => $this->traffic_clearing_office_id,
            "traffic_clearing_office" =>new  ShowTrafficClearingOfficeResource($this->traffic_office),
            "fees" => $this->fees,
            "price" => $this->price,
            "card_discount_value" => $this->card_discount_value,
            "card_price_after_discount" => $this->card_price_after_discount,
            "card_number_of_uses_times" => $this->card_number_of_uses_times,
            "notes" => $this->notes,
        ];
    }

}
