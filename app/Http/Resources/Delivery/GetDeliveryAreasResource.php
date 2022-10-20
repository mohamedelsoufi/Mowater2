<?php

namespace App\Http\Resources\Delivery;

use Illuminate\Http\Resources\Json\JsonResource;

class GetDeliveryAreasResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'country' => $this->country->name,
            'city' => $this->city->name,
            'area' => $this->area->name,
        ];
    }
}
