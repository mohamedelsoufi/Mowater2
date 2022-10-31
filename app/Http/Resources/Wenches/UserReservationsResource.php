<?php

namespace App\Http\Resources\Wenches;

use Illuminate\Http\Resources\Json\JsonResource;

class UserReservationsResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "reservable_type" => $this->reservable_type,
            "reservable_id" => $this->reservable_id,
            "user_id" => $this->user_id,
            "first_name" => $this->first_name,
            "last_name" => $this->last_name,
            "nickname" => $this->nickname,
            "country_code" => $this->country_code,
            "phone" => $this->phone,
            "nationality" => $this->nationality,
            "services" => $this->services,
            "address" => $this->address,
            "distinctive_mark" => $this->distinctive_mark,
            "is_mawater_card" => $this->is_mawater_card,
            "price" => $this->price,
            "from" => $this->from,
            "to" => $this->to,
            "date" => $this->date,
            "time" => $this->time,
            "status" => $this->status,
        ];
    }
}
