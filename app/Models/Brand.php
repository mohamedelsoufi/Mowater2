<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Brand extends Model
{
    use HasFactory;
    protected $table = 'brands';
    public $timestamps = true;
    protected $guarded = [];
    protected $hidden = array('name_en', 'name_ar', 'created_at', 'updated_at');

    protected $appends = ['name'];

    //// appends attributes start //////
    public function getNameAttribute()
    {
        if (App::getLocale() == 'ar')
            return $this->name_ar;
        return $this->name_en;
    }
    //// appends attributes end //////

    //relationship start
    public function manufacture_country()
    {
        return $this->belongsTo('App\Models\ManufactureCountry');
    }

    public function car_model()
    {
        return $this->hasMany(CarModel::class);
    }

    public function agency()
    {
        return $this->hasOne(Agency::class);
    }
    //relationship end

    // scopes start
    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function scopeSelection($query){
        return $query->select('id','name_en', 'name_ar', 'logo','active', 'manufacture_country_id');
    }

    public function scopeSearch($query)
    {

        $query->when(request()->search, function ($q) {
            return $q->where('name_ar', 'like', '%' . request()->search . '%')
                ->orWhere('name_en', 'like', '%' . request()->search . '%');
        })->when(request()->manufacture_country_id, function ($q) {
            return $q->where('manufacture_country_id',request()->manufacture_country_id);
        })->when(request()->agency_id, function ($q) {
            return $q->whereHas('agency', function ($q2) {
                $q2->where('id', request()->agency_id);
            });
        });;
    }
    // scopes end

    // accessors & Mutator start
    public function getLogoAttribute($val)
    {
        return asset('uploads') . '/' . $val;
    }

    public function getActive()
    {
        return $this->active == 1 ? __('words.active') : __('words.inactive');
    }

    public function setNameEnAttribute($val)
    {
        $this->attributes['name_en'] = ucwords($val);
    }
    // accessors & Mutator end
}
