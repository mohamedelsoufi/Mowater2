<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Area extends Model
{
    use HasFactory;
    protected $table = 'areas';
    public $timestamps = true;
    protected $fillable = array('name_en', 'name_ar', 'city_id', 'created_by');
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
    public function city()
    {
        return $this->belongsTo(City::class);
    }
    // relationship end

    // scopes start
    public function scopeSelection($query){
        return $query->select('id','name_en', 'name_ar','city_id');
    }

    public function scopeSearch($query)
    {
        $query->when(request()->city_id, function ($q) {
            return $q->where('city_id', request()->city_id);
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
