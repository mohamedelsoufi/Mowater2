<?php

namespace App\Http\Resources\Features;

use Illuminate\Http\Resources\Json\JsonResource;

class MawaterOffersResource extends JsonResource
{
    public function toArray($request)
    {

        return [
            "id"=>$this-> id,
            "name"=>$this-> name,
            "insurance_company_id"=>$this-> insurance_company_id,
            "coverage_type_id"=>$this-> coverage_type_id,
            "price"=>$this-> price,
            "discount"=>$this-> discount,
            "discount_type"=>$this-> discount_type,
            "price_after_discount"=>$this-> price_after_discount,
            "card_discount_value"=>$this-> card_discount_value,
            "card_price_after_discount"=>$this-> card_price_after_discount,
            "card_number_of_uses_times"=>$this-> card_number_of_uses_times,
            "notes"=>$this-> notes,
            "active"=>$this-> active,
        ];
    }
}
