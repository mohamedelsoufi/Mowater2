<?php

namespace App\Http\Resources\TrafficClearingOffices;

use Illuminate\Http\Resources\Json\JsonResource;

class GetServicesResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
