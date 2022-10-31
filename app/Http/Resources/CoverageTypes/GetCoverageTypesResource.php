<?php

namespace App\Http\Resources\CoverageTypes;

use Illuminate\Http\Resources\Json\JsonResource;

class GetCoverageTypesResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
        ];
    }
}
