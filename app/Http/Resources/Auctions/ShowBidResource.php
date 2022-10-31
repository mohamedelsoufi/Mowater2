<?php

namespace App\Http\Resources\Auctions;

use Illuminate\Http\Resources\Json\JsonResource;

class ShowBidResource extends JsonResource
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
            'bidder_name'=> $this->user->nickname .': '. $this->user->first_name . ' '. $this->user->last_name,
            'bidder_profile_image'=>$this->user->profile_image,
            'bid_amount'=>$this->bid_amount,
        ];
    }
}
