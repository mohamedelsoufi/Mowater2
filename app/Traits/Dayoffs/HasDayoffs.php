<?php


namespace App\Traits\Dayoffs;

trait HasDayoffs
{

    public function day_offs()
    {
        return $this->morphMany('App\Models\DayOff', 'model');
    }

}
