<?php


namespace App\Traits\Services;

trait HasServices
{

    public function services()
    {
        return $this->morphMany('App\Models\Service', 'servable');
    }
}
