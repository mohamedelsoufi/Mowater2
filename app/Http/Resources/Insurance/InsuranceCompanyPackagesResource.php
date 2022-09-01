<?php

namespace App\Http\Resources\Insurance;

use App\Http\Resources\Features\GetFeaturesResource;
use Illuminate\Http\Resources\Json\JsonResource;

class InsuranceCompanyPackagesResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "insurance_company_id" => $this->insurance_company_id,
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
