<?php

namespace App\Http\Resources\Brokers;

use App\Http\Resources\Features\GetFeaturesResource;
use Illuminate\Http\Resources\Json\JsonResource;

class BrokerPackagesResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "broker_id" => $this->broker_id,
            "coverage_type_id" => $this->coverage_type_id,
            "coverage_type" => $this->coverageType,
            "price" => $this->price,
            "discount" => $this->discount,
            "discount_type" => $this->discount_type,
            "price_after_discount" => $this->price_after_discount,
            "features" => GetFeaturesResource::collection($this->features),
            "active" => $this->active,
        ];
    }
}
