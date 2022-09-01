<?php

namespace App\Http\Resources\DiscountCards;

use App\Models\Vehicle;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowUserDiscountCardResource extends JsonResource
{
    public function toArray($request)
    {
        $data =[];
        if (! $this->pivot->vehicles == null){
            $vehicles_ids_to_array = array_map('intval', explode(',', $this->pivot->vehicles));

            foreach ($vehicles_ids_to_array as $id) {
                $vehicle_response = Vehicle::find($id);
                if (!$vehicle_response)
                    return responseJson(0, 'error', __('message.vehicle_id') . $id . ' ' . __('message.not_exist'));

                $data[] = [
                    "id" => $vehicle_response->id,
                    "vehicle_name" => $vehicle_response->vehicle_name,
                    "brand" => $vehicle_response->brand->name,
                    "car_model" => $vehicle_response->car_model->name,
                    "car_class" => $vehicle_response->car_class->name,
                    "manufacturing_year" => $vehicle_response->manufacturing_year,
                    "one_image" => $vehicle_response->one_image,
                ];
            }
        }

        return [
            "id" => $this->id,
            "title" => $this->title,
            "description" => $this->description,
            "original_price" => $this->price,
            "price" => $this->pivot->price,
            "year" => $this->year,
            "image" => $this->image,
            "status" => $this->status,
            "active" => $this->active,
            "user_id" => $this->pivot->user_id,
            "discount_card_id" => $this->pivot->discount_card_id,
            "barcode" => $this->pivot->barcode,
            "vehicles" => $data == null ? [] : $data,
        ];
    }
}
