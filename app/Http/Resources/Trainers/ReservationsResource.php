<?php

namespace App\Http\Resources\Trainers;

use Illuminate\Http\Resources\Json\JsonResource;

class ReservationsResource extends JsonResource
{
    public function toArray($request)
    {
        $data = [];
        $data["id"] = $this->id;
        $data["user_id"] = $this->user_id;
        if ($request->routeIs("training-reservations.show")){
            $data["user"] = $this->user;
        }

        $data["first_name"] = $this->first_name;
        $data["last_name"] = $this->last_name;
        $data["nickname"] = $this->nickname;
        $data["country_code"] = $this->country_code;
        $data["phone"] = $this->phone;
        $data["nationality"] = $this->nationality;
        $data["age"] = $this->age;
        $data["driving_trainer_id"] = $this->driving_trainer_id;
        if ($request->routeIs("training-reservations.show")){
            $data["trainer"] = new GetTrainersResource($this->trainer);
        }

        $data["is_previous_license"] = $this->is_previous_license;
        $data["attended_the_theoretical_driving_training_session"] = $this->attended_the_theoretical_driving_training_session;
        $data["training_type_id"] = $this->training_type_id;
        if ($request->routeIs("training-reservations.show")){
            $data["training_type"] = $this->training_type;
            $data["sessions"] = $this->reservation_sessions;
        }

        $data["price"] = $this->price;
        $data["status"] = $this->status;
        return $data;
    }
}
