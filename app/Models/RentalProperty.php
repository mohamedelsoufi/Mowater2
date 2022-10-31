<?php

namespace App\Models;

use App\Traits\Files\HasFile;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class RentalProperty extends Model
{
    use HasFactory,HasFile;

    protected $table = 'rental_properties';

    protected $guarded = [];

    protected $hidden = ['name_en', 'name_ar', 'description_en', 'description_ar', 'created_at', 'updated_at'];

    protected $appends = ['name', 'description'];

    public $timestamps = true;

    // appends attributes start //
    public function getNameAttribute()
    {
        if (App::getLocale() == 'ar') {
            return $this->name_ar;
        }
        return ucwords($this->name_en);
    }

    public function getDescriptionAttribute()
    {
        if (App::getLocale() == 'ar') {
            return $this->description_ar;
        }
        return ucwords($this->description_en);
    }
    // appends attributes End //

    //relationship start
    public function cars()
    {
        return $this->belongsToMany(RentalOfficeCar::class,'rental_office_car_properties');
    }
    //relationship end

    // accessors & Mutator start

    // accessors & Mutator end
}
