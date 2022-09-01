<?php

namespace App\Http\Resources\Vehicles;

use Illuminate\Http\Resources\Json\JsonResource;

class GetReservedVehiclesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "vehicle_id" => $this->vehicle_id,
            "first_name" => $this->first_name,
            "last_name" => $this->last_name,
            "nickname" => $this->nickname,
            "id_number" => $this->id_number,
            "country_code" => $this->country_code,
            "phone" => $this->phone,
            "nationality" => $this->nationality,
            "branch_id" => $this->branch_id,
            "user_id" => $this->user_id,
            "is_mawater_card" => $this->is_mawater_card,
            "price" => $this->price,
            "personal_ID" => $this->files()->where('type', 'personal_ID')->first()->path,
            "driving_license" => $this->files()->where('type', 'driving_license')->first()->path,
            "status" => $this->status,
        ];
    }
}
