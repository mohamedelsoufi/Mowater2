<?php


namespace App\Traits\Phones;

trait HasPhones
{

    public function phones()
    {
        return $this->morphMany('App\Models\Phone', 'phoneable');
    }

}
