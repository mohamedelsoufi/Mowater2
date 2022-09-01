<?php

namespace App\Http\Resources\Sections;

use App\Http\Resources\Ads\GetAdsResource;
use Illuminate\Http\Resources\Json\JsonResource;

class GetSectionsResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "ref_name" => $this->ref_name,
            "section_id" => $this->section_id,
            "file_url" => $this->file_url,
            "sub_sections" => $this->sub_sections,
            "ads" => $this->ads,
        ];
    }
}
