<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class PaymentMethod extends Model
{
    use HasFactory;
    protected $table = 'payment_methods';
    public $timestamps = true;
    protected $guarded = [];
    protected $hidden = ['created_at', 'updated_at', 'name_en', 'name_ar'];
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
    public function rental_offices()
    {
        return $this->morphedByMany(RentalOffice::class, 'model');
    }
    // relationship end

    // accessors & Mutator start
    public function setNameEnAttribute($val)
    {
        $this->attributes['name_en'] = ucwords($val);
    }

    public function getSymbolAttribute($val)
    {
        return asset('uploads') . '/' . $val;
    }
    // accessors & Mutator end
}
