<?php

namespace App\Http\Resources\Auctions;

use Illuminate\Http\Resources\Json\JsonResource;

class ShowAuctionResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "insurance_company_id" => $this->insurance_company_id,
            "logo" => $this->insurance_company->logo,
            "serial_number" => $this->serial_number,
            "insurance_amount" => $this->insurance_amount,
            "min_bid" => $this->min_bid,
            "number_of_views" => $this->number_of_views,
            "active_number_of_views" => $this->active_number_of_views,
            "winner" => $this->user_id,
            "active" => $this->active,
            "number_of_subscriptions" => $this->users()->count(),
            "started_date" => $this->start_date(),
            "ending_date" => $this->end_date(),
            "max_bid" => $this->ending_date,
            "status" => $this->status,
            "duration" => $this->duration,
            "vehicles" => $this->vehicles,
            "insurance_company" => $this->insurance_company
        ];
    }
}
