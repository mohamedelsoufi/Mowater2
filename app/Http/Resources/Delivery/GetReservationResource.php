<?php

namespace App\Http\Resources\Delivery;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class GetReservationResource extends JsonResource
{

    public function toArray($request)
    {
        $number_of_repetitions = explode(',',$this->number_of_repetitions);
        foreach ($number_of_repetitions as $number_of_repetition){
          $dates[] = Carbon::parse($number_of_repetition)->format('d-m-Y h:i A');
        }

        $data['delivery_man_id']=$this->delivery_man_id;
        if ($request->routeIs('delivery-reservations.show')){
            $data['delivery_man']=$this->delivery_man;
        }

        $data['user_id']=$this->user_id;
        if ($request->routeIs('delivery-reservations.show')){
            $data['user']=$this->user;
        }
        $data['first_name']=$this->first_name;
        $data['last_name']=$this->last_name;
        $data['nickname']=$this->nickname;
        $data['country_code']=$this->country_code;
        $data['phone']=$this->phone;
        $data['nationality']=$this->nationality;
        $data['category_id']=$this->category_id;
        $data['from']=$this->from;
        $data['to']=$this->to;
        $data['address']=$this->address;
        $data['distinctive_mark']=$this->distinctive_mark;
        $data['day_to_go']=Carbon::parse($this->day_to_go)->format('d-m-Y h:i A');
        $data['request_type']=$this->request_type;
        $data['number_of_repetitions']=$dates;
        $data['price']=$this->price;
        $data['is_mawater_card']=$this->is_mawater_card;
        $data['status']=$this->status;
        return $data;
    }
}
