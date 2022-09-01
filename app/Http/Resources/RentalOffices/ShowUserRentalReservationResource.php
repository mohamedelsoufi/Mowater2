<?php

namespace App\Http\Resources\RentalOffices;

use Illuminate\Http\Resources\Json\JsonResource;

class ShowUserRentalReservationResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "rental_office_car_id" => $this->rental_office_car_id,
            "rental_office_car" => $this->rental_office_car,
            "branch_id" => $this->branch_id,
            "branch" => $this->branch,
            "user_id" => $this->user_id,
            "first_name" => $this->first_name,
            "last_name" => $this->last_name,
            "nickname" => $this->nickname,
            "country_code" => $this->country_code,
            "phone" => $this->phone,
            "nationality" => $this->nationality,
            "id_type" => $this->id_type,
            "id_number" => $this->id_number,
            "credit_card_number" => $this->credit_card_number,
            "insurance_amount" => $this->insurance_amount,
            "is_mawater_card" => $this->is_mawater_card,
            "receive_type" => $this->receive_type,
            "address" => $this->address,
            "start_date" => $this->start_date,
            "end_date" => $this->end_date,
            "price" => $this->price,
            "status" => $this->status,
        ];
    }
}
