<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class CarModel extends Model
{
    use HasFactory;
    protected $table = 'car_models';
    public $timestamps = true;
    protected $fillable = array('id','name_en', 'name_ar', 'active', 'brand_id','created_by');
    protected $hidden = ['created_at', 'updated_at','name_en', 'name_ar'];
    protected $appends = ['name'];

    // appends attributes start
    public function getNameAttribute()
    {
        if (App::getLocale() == 'ar') {
            return $this->name_ar;
        }
        return $this->name_en;
    }
    // appends attributes end

    //relationship start
    public function brand()
    {
        return $this->belongsTo('App\Models\Brand');
    }

    public function main_vehicles(){
        return $this->hasMany(MainVehicle::class);
    }

    //relationship end

    // scopes
    public function scopeSelection($query){
        return $query->select('id','name_ar','name_en','brand_id');
    }

    // scopes start
    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function scopeSearch($query)
    {

        $query->when(request()->search, function ($q) {
            return $q->where('name_ar', 'like', '%' . request()->search . '%')
                ->orWhere('name_en', 'like', '%' . request()->search . '%');
        });
    }
    // scopes end

    // accessors & Mutator start
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
