<?php

namespace App\Http\Resources\Vehicles;

use Illuminate\Http\Resources\Json\JsonResource;

class ShowTestDriveResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "vehicle_id" => $this->vehicle_id,
            "first_name" => $this->first_name,
            "last_name" => $this->last_name,
            "nickname" => $this->nickname,
            "country_code" => $this->country_code,
            "phone" => $this->phone,
            "nationality" => $this->nationality,
            "date" => date('d-m-Y', strtotime($this->date)),
            "time" => date('h:i a', strtotime($this->time)),
            "branch_id" => $this->branch_id,
            "user_id" => $this->user_id,
            "status" => $this->status,
            "vehicle" => new ShowVehicleResource($this->vehicle),
            "driving_license" => $this->files()->where('type','driving_license_for_test')->first()->path
        ];
    }
}
