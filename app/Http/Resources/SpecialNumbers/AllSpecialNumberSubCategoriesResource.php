<?php

namespace App\Http\Resources\SpecialNumbers;

use Illuminate\Http\Resources\Json\JsonResource;

class AllSpecialNumberSubCategoriesResource extends JsonResource
{
    public function toArray($request)
    {

        $array = [
            'id' => $this->id,
            'name' => $this->name,
            'number_of_digits' =>$this->number_of_digits,
            'category_id' => $this->category_id
        ];


        return $array;

    }
}
