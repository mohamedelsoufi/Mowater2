<?php

namespace App\Models;

use Illuminate\Support\Facades\App;
use Laratrust\Models\LaratrustPermission;

class Permission extends LaratrustPermission
{
    public $guarded = [];

    protected $appends = ['display_name', 'description'];

    // appends attributes start
    public function getDescriptionAttribute()
    {
        if (App::getLocale() == 'ar') {
            return $this->display_name_ar;
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
}
