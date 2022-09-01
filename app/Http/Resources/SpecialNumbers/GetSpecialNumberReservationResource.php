<?php

namespace App\Http\Resources\SpecialNumbers;

use Illuminate\Http\Resources\Json\JsonResource;

class GetSpecialNumberReservationResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "special_number_id" => $this->special_number_id,
            "user_id" => $this->user_id,
            "first_name" => $this->first_name,
            "last_name" => $this->last_name,
            "nickname" => $this->nickname,
            "country_code" => $this->country_code,
            "phone" => $this->phone,
            "nationality" => $this->nationality,
            "credit_card_number" => $this->credit_card_number,
            "price" => $this->price,
            "is_mawater_card" => $this->is_mawater_card,
            "personal_id" => $this->files()->where('type', 'personal_ID_for_special')->first()->path,
            "driving_license" => $this->files()->where('type', 'driving_license_for_special')->first()->path
        ];
    }
}
