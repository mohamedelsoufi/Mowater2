<?php

namespace App\Http\Resources\Insurance;

use Illuminate\Http\Resources\Json\JsonResource;

class InsuranceMowaterOffersResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "insurance_company_id" => $this->insurance_company_id,
            "insurance_company" => $this->insuranceCompany->name,
            "coverage_type_id" => $this->coverage_type_id,
            "coverage_type" => $this->coverageType->name,
            "price" => $this->price,
            "card_discount_value" => $this->card_discount_value,
            "card_price_after_discount" => $this->card_price_after_discount,
            "card_number_of_uses_times" => $this->card_number_of_uses_times,
            "notes" => $this->notes,
            "active" => $this->active,
        ];
    }
}
