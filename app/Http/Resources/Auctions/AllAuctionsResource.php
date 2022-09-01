<?php

namespace App\Http\Resources\Auctions;

use Illuminate\Http\Resources\Json\JsonResource;

class AllAuctionsResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "serial_number" => $this->serial_number,
            "vehicle_image" => $this->vehicles()->first()->one_image,
            "brand" => $this->vehicles()->first()->brand->name,
            "car_model" => $this->vehicles()->first()->car_model->name,
            "car_class" => $this->vehicles()->first()->car_class->name,
            "manufacturing_year" => $this->vehicles()->first()->manufacturing_year,
            "vehicle_price" => $this->vehicles()->first()->vehicle_price,
            "insurance_company_name" => $this->insurance_company->name,
            "logo" => $this->insurance_company->logo,
            "started_date" => $this->start_date(),
            "ending_date" => $this->end_date(),
            "max_bid" => $this->max_bid,
            "status" => $this->status,
            "duration" => $this->duration
        ];
    }
}
