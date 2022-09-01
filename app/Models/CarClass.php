<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class CarClass extends Model
{
    use HasFactory;
    protected $table = 'car_classes';
    public $timestamps = true;
    protected $fillable = array('id','name_en', 'name_ar', 'active');
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

    // relations start
    public function vehicles(){
        return $this->hasMany(Vehicle::class);
    }
    // relations end

    // scopes start
    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function scopeSearch($query){
        $query->when(request()->search, function ($q) {
            return $q->where('name_ar', 'like', '%' . request()->search . '%')
                ->orWhere('name_en', 'like', '%' . request()->search . '%');
        })->when(request()->brand_id,function ($q){
            return $q->whereHas('vehicles',function (Builder $query){
               $query->where('brand_id', request()->brand_id);
            });
        })->when(request()->car_model_id,function ($q){
            return $q->whereHas('vehicles',function (Builder $query){
               $query->where('car_model_id', request()->car_model_id);
            });
        })->when(request()->manufacturing_year,function ($q){
            return $q->whereHas('vehicles',function (Builder $query){
               $query->where('manufacturing_year', request()->manufacturing_year);
            });
        });
    }

    public function scopeSelection($query){
       return $query->select('id','name_ar','name_en','active');
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
