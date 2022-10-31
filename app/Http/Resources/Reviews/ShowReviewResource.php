<?php

namespace App\Http\Resources\Reviews;

use Illuminate\Http\Resources\Json\JsonResource;

class ShowReviewResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "reviewable_type" => $this->reviewable_type,
            "reviewable_id" => $this->reviewable_id,
            "user_id" => $this->user_id,
            "user" => $this->user,
            "rate" => $this->rate,
            "review" => $this->review,
            "created_at" => $this->created_at,
        ];
    }
}
