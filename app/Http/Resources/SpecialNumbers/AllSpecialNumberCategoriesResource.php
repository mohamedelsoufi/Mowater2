<?php

namespace App\Http\Resources\SpecialNumbers;

use Illuminate\Http\Resources\Json\JsonResource;

class AllSpecialNumberCategoriesResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'sub_category' => AllSpecialNumberSubCategoriesResource::collection($this->sub_categories)
        ];
    }
}
