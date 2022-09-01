<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class ManufactureCountry extends Model
{
    use HasFactory;
    protected $table = 'manufacture_countries';
    public $timestamps = true;
    protected $fillable = array('id', 'name_en', 'name_ar', 'active');
    protected $hidden = ['name_en', 'name_ar', 'created_at', 'updated_at'];
    protected $appends = ['name'];

    // appends attributes start
    public function getNameAttribute()
    {
        if (App::getLocale() == 'ar')
            return $this->name_ar;
        return $this->name_en;
    }
    // appends attributes end

    // relationship start
    public function brands()
    {
        return $this->hasMany('App\Models\Brand');
    }

    // relationship end

    // scopes start
    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
    // scopes end

    // accessors & Mutator start
    public function setNameEnAttribute($val)
    {
        $this->attributes['name_en'] = ucwords($val);
    }

    public function getActive()
    {
        return $this->active == 1 ? __('words.active') : __('words.inactive');
    }
    // accessors & Mutator end
}
