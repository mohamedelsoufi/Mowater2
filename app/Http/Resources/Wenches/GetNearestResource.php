<?php

namespace App\Http\Resources\Wenches;

use App\Models\Wench;
use Illuminate\Http\Resources\Json\JsonResource;

class GetNearestResource extends JsonResource
{
    public function toArray($request)
    {
       $data = Wench::find($this->id);

        return [
            "id" => $this->id,
            "name" => $data->name,
            "logo" => $data->logo,
            "rating" => $data->rating,
            "latitude" => $this->latitude,
            "longitude" => $this->longitude,
            "distance_in_km" => $this->distance_in_km,
            "available" => $this->available,
            "active" => $this->active,
        ];
    }
}
