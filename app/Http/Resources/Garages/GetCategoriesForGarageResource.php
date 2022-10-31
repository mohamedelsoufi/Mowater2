<?php

namespace App\Http\Resources\Garages;

use Illuminate\Http\Resources\Json\JsonResource;

class GetCategoriesForGarageResource extends JsonResource
{
    public function toArray($request)
    {
        $data=[];
        foreach ($this->sub_categories as $sub_category) {
            $data[] = [
                "id" => $sub_category->id,
                "name" => $sub_category->name,
                "category_id" => $sub_category->category_id,
            ];
        }
        return [
            "id" => $this->id,
            "name" => $this->name,
            "section_id" => $this->section_id,
            "sub_categories" => $data,
        ];
    }
}
