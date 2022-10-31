<?php


namespace App\Traits\WorkTimes;

trait HasWorkTimes
{


    public function work_time()
    {
        return $this->morphOne('App\Models\WorkTime', 'workable');
    }

}
