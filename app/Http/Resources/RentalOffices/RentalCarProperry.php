<?php

namespace App\Http\Resources\RentalOffices;

use Illuminate\Http\Resources\Json\JsonResource;

class RentalCarProperry extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "description" => $this->description,
        ];
    }
}
