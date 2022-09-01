<?php

namespace App\Http\Resources\Cities;

use Illuminate\Http\Resources\Json\JsonResource;

class GetCitiesResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id"=>$this->id,
            "name"=>$this->name,
            "latitude"=>$this->latitude,
            "longitude"=>$this->longitude,
            "country_id"=>$this->country_id,
            "country"=>$this->country,
        ];
    }
}
