<?php

namespace App\Http\Resources\Vehicles;

use Illuminate\Http\Resources\Json\JsonResource;

class GetEngineSizesResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "vehicle_id" => $this->id,
            "engine_size" => $this->engine_size,
            "image" => $this->one_image,
        ];
    }
}
