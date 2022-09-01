<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Color extends Model
{
    use HasFactory;

    protected $table = 'colors';
    protected $fillable = ['id','color_name','color_name_ar','color_code'];
    protected $hidden = ['created_at','updated_at','color_name','color_name_ar'];
    protected $appends = ['name'];

    //// appends attributes start //////
    public function getNameAttribute()
    {
        if (App::getLocale() == 'ar')
            return $this->color_name_ar;
        return $this->color_name;
    }
    //// appends attributes end //////

    // relations start
    public function vehicles(){
        return $this->hasMany(Vehicle::class);
    }
    // relations end
}
