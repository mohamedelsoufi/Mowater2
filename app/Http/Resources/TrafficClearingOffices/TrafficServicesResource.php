<?php

namespace App\Http\Resources\TrafficClearingOffices;

use Illuminate\Http\Resources\Json\JsonResource;

class TrafficServicesResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "fees" => $this->pivot->fees,
            "price" => $this->pivot->price,
        ];
    }
}
