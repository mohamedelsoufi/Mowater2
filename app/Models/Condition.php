<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Condition extends Model
{
    use HasFactory;

    protected $table = 'conditions';

    protected $guarded = [];

    protected $hidden = ['created_at', 'updated_at','created_by','description_en','description_ar'];

    protected $appends = ['description'];

    public $timestamps = true;

    // appends attributes start
    public function getDescriptionAttribute()
    {
        if (App::getLocale() == 'ar') {
            return $this->description_ar;
        }
        return $this->description_en;
    }
    // appends attributes end

    // relations start
    public function conditionable()
    {
        return $this->morphTo();
    }
    // relations end
}
