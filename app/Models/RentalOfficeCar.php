<?php

namespace App\Models;

use App\Traits\Ads\HasAds;
use App\Traits\Files\HasFiles;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentalOfficeCar extends Model
{
    use HasFactory, HasFiles, HasAds;
    protected $table = 'rental_office_cars';
    public $timestamps = true;
    protected $guarded = [];
    protected $hidden = ['created_at', 'updated_at'];
    protected $appends = ['one_image'];

    //relationship start
    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function car_model()
    {
        return $this->belongsTo(CarModel::class, 'car_model_id');
    }

    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    public function rental_office()
    {
        return $this->belongsTo('App\Models\RentalOffice');
    }

    public function car_class()
    {
        return $this->belongsTo('App\Models\CarClass');
    }

    public function rental_reservations()
    {
        return $this->hasMany('App\Models\RentalReservation');
    }

    public function offers()
    {
        return $this->morphMany(Offer::class, 'offerable');
    }

    public function properties()
    {
        return $this->belongsToMany(RentalProperty::class, 'rental_office_car_properties');
    }
    //relationship end

    //    Scopes
    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function scopeAvailable($query)
    {
        return $query->where('available', 1);
    }

    public function getOneImageAttribute()
    {
        $default_image = $this->files()->first();
        return $default_image ? $default_image->path : '';
    }

    public function getVehicleTypeAttribute($val)
    {
        if ($val == 'economy_cars')
            return __('vehicle.economy_cars');
        if ($val == 'sedan')
            return __('vehicle.sedan');
        if ($val == 'ٍsports_cars')
            return __('vehicle.ٍsports_cars');
        if ($val == 'rental_four_wheel_drive')
            return __('vehicle.rental_four_wheel_drive');
        if ($val == 'luxury')
            return __('vehicle.luxury');
        if ($val == 'pick_up')
            return __('vehicle.pick_up');
        if ($val == 'van')
            return __('vehicle.van');

    }

    public function scopeSearch($query)
    {
        $query->when(request()->brand_id, function ($q) {
            return $q->where('brand_id', request()->brand_id);
        })->when(request()->car_model_id, function ($q) {
            return $q->where('car_model_id', request()->car_model_id);
        })->when(request()->car_class_id, function ($q) {
            return $q->where('car_class_id', request()->car_class_id);
        })->when(request()->vehicle_type, function ($q) {
            return $q->where('vehicle_type', 'like', '%' . request()->vehicle_type . '%');
        })->when(request()->manufacture_year, function ($q) {
            return $q->where('manufacture_year', request()->manufacture_year);
        });

    }

}
