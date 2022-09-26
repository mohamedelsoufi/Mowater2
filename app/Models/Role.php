<?php

namespace App\Models;

use Illuminate\Support\Facades\App;
use Laratrust\Models\LaratrustRole;

class Role extends LaratrustRole
{
    public $guarded = [];

    protected $appends = ['name', 'display_name', 'description'];

    // appends attributes start
    public function getNameAttribute()
    {
        if (App::getLocale() == 'ar') {
            return $this->name_ar;
        }
        return $this->name_en;
    }

    public function getDescriptionAttribute()
    {
        if (App::getLocale() == 'ar') {
            return $this->description_ar;
        }
        return $this->description_en;
    }

    public function getDisplayNameAttribute()
    {
        if (App::getLocale() == 'ar') {
            return $this->display_name_ar;
        }
        return $this->display_name_en;
    }
    // appends attributes End

    // relations start
    public function rolable(){
        return $this->morphTo();
    }
    // relations end
}
