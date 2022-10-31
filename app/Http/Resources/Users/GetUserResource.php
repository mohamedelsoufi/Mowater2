<?php

namespace App\Http\Resources\Users;

use Illuminate\Http\Resources\Json\JsonResource;

class GetUserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "profile_image" => $this->profile_image,
            "first_name" => $this->first_name,
            "last_name" => $this->last_name,
            "nickname" => $this->nickname,
            "phone_code" => $this->phone_code,
            "phone" => $this->phone,
            "nationality" => $this->nationality,
            "country_id" => $this->country_id,
            "city_id" => $this->city_id,
            "area_id" => $this->area_id,
        ];
    }
}
