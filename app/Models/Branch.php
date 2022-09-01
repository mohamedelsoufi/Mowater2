<?php

namespace App\Models;

use App\Traits\PaymentMethods\HasPaymentMethods;
use App\Traits\Phones\HasPhones;
use App\Traits\Products\HasProducts;
use App\Traits\Reservations\CanBeReserved;
use App\Traits\Services\HasServices;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Contacts\HasContacts;
use App\Traits\Favourites\CanBeFavourites;
use App\Traits\OrganizationUsers\HasOrgUsers;
use App\Traits\Reviews\HasReviews;
use App\Traits\WorkTimes\HasWorkTimes;
use App\Traits\Dayoffs\HasDayoffs;
use App;

class Branch extends Model
{
    use CanBeFavourites, HasContacts, HasReviews, HasWorkTimes, HasDayoffs, HasOrgUsers,
        HasServices, HasProducts, CanBeReserved,HasPaymentMethods,HasPhones;

    protected $table = 'branches';
    public $timestamps = true;
    protected $guarded = [];
    protected $hidden = ['created_at', 'updated_at'];
    protected $appends = ['name', 'address','favorites_count'];


    public function getNameAttribute()
    {
        if (App::getLocale() == 'ar') {
            return $this->name_ar;
        }
        return $this->name_en;
    }

    public function getAddressAttribute()
    {
        if (App::getLocale() == 'ar') {
            return $this->address_ar;
        }
        return $this->address_en;
    }

    //relationship start
    public function branchable()
    {
        return $this->morphTo();
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function city()
    {
        return $this->belongsTo('App\Models\City');
    }

    public function area()
    {
        return $this->belongsTo('App\Models\Area');
    }

    public function available_vehicles()
    {
        return $this->morphedByMany('App\Models\Vehicle', 'usable', 'branch_use');
    }

    public function available_features()
    {
        return $this->morphedByMany(Feature::class, 'usable', 'branch_use');
    }

    public function tests()
    {
        return $this->hasMany('App\Models\TestDrive');
    }

    public function available_products()
    {
        return $this->morphedByMany('App\Models\Product', 'usable', 'branch_use');
    }

    public function available_services()
    {
        return $this->morphedByMany('App\Models\Service', 'usable', 'branch_use');
    }

    public function available_rental_cars()
    {
        return $this->morphedByMany(RentalOfficeCar::class, 'usable', 'branch_use');
    }

    public function reserve_vehicles()
    {
        return $this->hasMany('App\Models\ReserveVehicle');
    }

    public function reservations()
    {
        return $this->hasMany('App\Models\Reservation');
    }

    public function trafficClearingOfficeRequests()
    {
        return $this->hasMany(TrafficClearingOffice::class);
    }

    public function insuranceReservations()
    {
        return $this->hasMany(ReserveInsuranceCompanyService::class);
    }

    public function brokerReservations()
    {
        return $this->hasMany(BrokerReservation::class);
    }


    //scopes
    public function scopeSearch($query)
    {
        $query->when(request()->search, function ($q) {
            return $q->where('name_ar', 'like', '%' . request()->search . '%')
                ->orWhere('name_en', 'like', '%' . request()->search . '%')
                ->orWhere('address_ar', 'like', '%' . request()->search . '%')
                ->orWhere('address_en', 'like', '%' . request()->search . '%');
        })->when(request()->city, function ($q) {
            return $q->where('city_id', request()->city);
        })->when(request()->area, function ($q) {
            return $q->where('area_id', request()->area);
        })->when(request()->category, function ($q) {
            return $q->where('category_id', request()->category);
        });

    }

}
