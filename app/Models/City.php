<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class City extends Model
{
    use HasFactory;
    protected $table = 'cities';
    public $timestamps = true;
    protected $guarded = [];
    protected $hidden = ['created_at', 'updated_at','name_en', 'name_ar'];
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
    public function country()
    {
        return $this->belongsTo('App\Models\Country');
    }

    public function areas()
    {
        return $this->hasMany('App\Models\Area');
    }
    // relationship end

    // scopes start

    public function scopeSearch($query)
    {
        $query->when(request()->country_id, function ($q) {
            return $q->where('country_id', request()->country_id);
        });
    }
    // scopes end

    // accessors & Mutator start
    public function setNameEnAttribute($val)
    {
        $this->attributes['name_en'] = ucwords($val);
    }
    // accessors & Mutator end
}
