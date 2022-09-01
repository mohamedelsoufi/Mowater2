<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Category extends Model
{
    use HasFactory;
    protected $table = 'categories';
    public $timestamps = true;
    protected $fillable = array('id', 'name_en', 'name_ar', 'section_id','ref_name');
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

    //relationship start
    public function delivery_men()
    {
        return $this->hasMany(DeliveryMan::class);
    }

    public function section()
    {
        return $this->belongsTo('App\Models\Section');
    }

    public function garages()
    {
        return $this->morphedByMany('App\Models\Garage', 'categorizable');
    }

    public function products()
    {
        return $this->hasMany('App\Models\Product');
    }

    public function delivery()
    {
        return $this->belongsTo(DeliveryManReservation::class, 'category_id');
    }

    public function sub_categories(){
        return $this->hasMany(SubCategory::class);
    }
    //relationship end

    // accessors & Mutator start
    public function setNameEnAttribute($val)
    {
        $this->attributes['name_en'] = ucwords($val);
    }
    // accessors & Mutator end
}
