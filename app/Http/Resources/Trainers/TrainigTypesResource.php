<?php

namespace App\Http\Resources\Trainers;

use Illuminate\Http\Resources\Json\JsonResource;

class TrainigTypesResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id"=>$this-> id,
            "type"=>$this-> type,
            "category"=>$this->category,
            "no_of_hours"=>$this->no_of_hours,
            "no_of_sessions"=>$this-> no_of_sessions
        ];
    }
}
