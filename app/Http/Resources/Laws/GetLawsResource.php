<?php

namespace App\Http\Resources\Laws;

use Illuminate\Http\Resources\Json\JsonResource;

class GetLawsResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "lawable_type" => $this->lawable_type,
            "lawable_id" => $this->lawable_id,
            "law" => $this->law,
        ];
    }
}
