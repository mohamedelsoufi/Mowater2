<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class AdType extends Model
{
    use HasFactory;
    protected $table = 'ad_types';
    protected $fillable = ['name_ar', 'name_en', 'priority', 'price', 'created_by'];
    protected $appends = ['name'];
    public $timestamps = true;

    // appends attributes start
    public function getNameAttribute()
    {
        if (App::getLocale() == 'ar') {
            return $this->name_ar;
        }
        return $this->name_en;
    }
    // appends attributes end

    // relations start
    public function ad()
    {
        return $this->belongsToMany(Ad::class);
    }
    // relations end

    // accessors & Mutator start
    public function getNameEnAttribute($val){
        return $this->attributes['name_en'] = ucfirst($val);
    }
    // accessors & Mutator end
}
