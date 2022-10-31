<?php

namespace App\Http\Resources\Vehicles;

use App\Models\Color;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class ShowVehicleResource extends JsonResource
{
    public function toArray($request)
    {
        $images=[];
        $colors = $this->files()->where('type','!=','traffic_pdf')->pluck('color_id')->unique()->toArray();
        foreach ($colors as $key => $color) {
            $files = $this->files()->where('color_id', $color)->get();

            $color_details = Color::where('id', $color)->first();
            $images[$key] = [
                'color_name' => $color_details->name,
                'color_code' => $color_details->color_code,
                'images' => $files
            ];
        }

        $array = [
            "id" => $this->id,
            "vehicable_id" => $this->vehicable_id,
            "vehicable_type" => $this->vehicable_type,
            "vehicle_type" => $this->vehicle_type,
            "brand_id" => $this->brand->id,
            "brand" => $this->brand,
            "car_model_id" => $this->car_model->id,
            "car_model" => $this->car_model,
            "car_class_id" => $this->car_class->id,
            "car_class" => $this->car_class,
            "manufacturing_year" => $this->manufacturing_year,
            "is_new" => $this->is_new,
            "price" => $this->price,
            "price_after_discount" => $this->price_after_discount,

            "time" => Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('d-m-Y H:i A'),
            "features" => $this->vehicleProperties(),
            "rating" => $this->rating,
            "rating_count" => $this->rating_count,
            "is_reviewed" => $this->is_reviewed,
            "reviews" => $this->reviews,
            "is_favorite" => $this->is_favorite,
            "favorites_count" => $this->favorites_count,
            "distance_color" => $this->distance_color,
            "number_of_views" => $this->number_of_views,
            "active_number_of_views" => $this->active_number_of_views,
            "availability" => $this->availability,
            "active" => $this->active,
            "files" => $this->files,
            "colors" => $images
        ];

        if ($this->is_new == 0) {
            $array['traffic_file'] = $this->getTrafficPdf();
        }
        return $array;
    }
}
