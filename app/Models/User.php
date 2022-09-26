<?php

namespace App\Models;

use App\Traits\PaymentMethods\HasPaymentMethods;
use App\Traits\Vehicles\HasVehicles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Laratrust\Traits\LaratrustUserTrait;

class User extends Authenticatable implements JWTSubject
{
    use LaratrustUserTrait;
    use HasFactory, Notifiable, HasVehicles, HasPaymentMethods;
    protected $table = 'users';
    public $timestamps = true;
    protected $fillable = array('id', 'first_name', 'last_name', 'nickname', 'email', 'phone_code', 'phone', 'password',
        'active', 'date_of_birth', 'is_verified',
        'gender', 'nationality', 'country_id', 'city_id', 'area_id', 'fcm_token', 'device_token',
        'platform', 'profile_image', 'created_by');
    protected $hidden = array('password', 'created_at', 'updated_at');

    // JWT auth start
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    // JWT auth end

    // relation start
    public function broker_reservatione()
    {
        return $this->hasMany(BrokerReservation::class);
    }

    public function delivery_reservations()
    {
        return $this->hasMany(DeliveryManReservation::class);
    }

    public function training_reservations()
    {
        return $this->hasMany(TrainingReservation::class);
    }

    public function reviews()
    {
        return $this->hasMany('App\Models\Review');
    }

    public function agencies_favourites()
    {
        return $this->morphedByMany('App\Models\Agency', 'favourable');
    }

    public function car_showrooms_favourites()
    {
        return $this->morphedByMany('App\Models\CarShowroom', 'favourable');
    }

    public function rental_offices_favourites()
    {
        return $this->morphedByMany('App\Models\RentalOffice', 'favourable');
    }

    public function special_number_organizations_favourites()
    {
        return $this->morphedByMany('App\Models\SpecialNumberOrganization', 'favourable');
    }

    public function garages_favourites()
    {
        return $this->morphedByMany('App\Models\Garage', 'favourable');
    }

    public function wenches_favourites()
    {
        return $this->morphedByMany('App\Models\Wench', 'favourable');
    }

    public function special_numbers()
    {
        return $this->hasMany('App\Models\SpecialNumber');
    }

    public function rental_office_reservation()
    {
        return $this->hasMany(RentalReservation::class);
    }

    public function notifications()
    {
        return $this->hasMany(FirebaseNotification::class);
    }

    public function special_number_verifications()
    {
        return $this->morphedByMany(SpecialNumber::class, 'model', 'verifications')->withPivot('status');
    }

    public function special_number_reservation()
    {
        return $this->hasMany(SpecialNumberReservation::class);
    }

    public function reserve_vehicles()
    {
        return $this->hasMany(ReserveVehicle::class);
    }

    public function test_drives()
    {
        return $this->hasMany(TestDrive::class);
    }

    public function country()
    {
        return $this->belongsTo('App\Models\Country');
    }

    public function city()
    {
        return $this->belongsTo('App\Models\City');
    }

    public function area()
    {
        return $this->belongsTo('App\Models\Area');
    }

    public function request_products()
    {
        return $this->hasMany(RequestProduct::class);
    }

    public function discount_cards()
    {
        return $this->belongsToMany(DiscountCard::class, 'discount_card_users', 'user_id', 'discount_card_id')
            ->withPivot('id', 'barcode', 'vehicles', 'price')->withTimestamps();
    }

    public function auctions()
    {
        return $this->belongsToMany(Auction::class, 'auction_subscription', 'user_id', 'auction_id');
    }

    public function bids()
    {
        return $this->hasMany(Bid::class);
    }

    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }

    public function trafficClearingOfficeRequests()
    {
        return $this->hasMany(TrafficClearingOfficeRequest::class);
    }

    public function reservations()
    {
        return $this->hasMany('App\Models\Reservation');
    }

    public function insuranceReservations()
    {
        return $this->hasMany(ReserveInsuranceCompanyService::class);
    }

    public function brokerReservations()
    {
        return $this->hasMany(BrokerReservation::class);
    }

    public function inspectionRequests()
    {
        return $this->hasMany(RequestTechnicalInspection::class);
    }

    public function carWashRequests()
    {
        return $this->hasMany(RequestCarWash::class);
    }

    public function accessoryStorePurchases()
    {
        return $this->hasMany(AccessoryStorePurchase::class);
    }

    public function replies()
    {
        return $this->hasManyThrough(RequestProductOrg::class, RequestProduct::class, 'user_id', 'request_product_id');
    }
    // relations end

    // Scopes start
    public function scopeSelection($query)
    {
        return $query->select('id', 'first_name', 'last_name', 'nickname', 'email', 'phone_code', 'phone', 'active',
            'date_of_birth', 'gender', 'nationality', 'country_id', 'city_id', 'area_id', 'fcm_token', 'device_token', 'platform', 'profile_image' . 'is_verified');
    }
    // Scopes end

    // accessors & Mutator start
    public function setPasswordAttribute($val)
    {
        $this->attributes['password'] = bcrypt($val);
    }

    public function setFirstNameAttribute($val)
    {
        $this->attributes['first_name'] =ucfirst($val);
    }

    public function setLastNameAttribute($val)
    {
        $this->attributes['last_name'] =ucfirst($val);
    }

    public function setNicknameAttribute($val)
    {
        $this->attributes['nickname'] =ucfirst($val);
    }

    public function getProfileImageAttribute($val)
    {
        return asset('uploads') . '/' . $val;
    }

    public function getIsVerified(){
        return $this->is_verified == 1 ? __('words.is_verified') : __('words.not_verified');
    }

    public function getActive()
    {
        return $this->active == 1 ? __('words.active') : __('words.inactive');
    }
    // accessors & Mutator end
}
