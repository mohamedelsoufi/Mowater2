<?php

namespace App\Models;

use App\Traits\Ads\HasAds;
use App\Traits\Contacts\HasContacts;
use App\Traits\Dayoffs\HasDayoffs;
use App\Traits\Favourites\CanBeFavourites;
use App\Traits\OrganizationDiscountCards\HasOrganizationDiscountCard;
use App\Traits\OrganizationUsers\HasOrgUsers;
use App\Traits\PaymentMethods\HasPaymentMethods;
use App\Traits\Phones\HasPhones;
use App\Traits\Reviews\HasReviews;
use App\Traits\WorkTimes\HasWorkTimes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class AccessoriesStore extends Model
{
    use HasFactory, CanBeFavourites, HasContacts, HasReviews, HasWorkTimes, HasDayoffs, HasAds,
        HasOrgUsers, HasPhones, HasOrganizationDiscountCard, HasPaymentMethods;

    protected $table = 'accessories_stores';

    protected $fillable =  ['id', 'logo', 'name_en', 'name_ar', 'description_en', 'description_ar',
        'tax_number', 'address', 'city_id', 'number_of_views','active_number_of_views', 'reservation_availability',
        'reservation_active','delivery_availability','delivery_active', 'available', 'active'];

    protected $appends = ['name', 'description', 'rating', 'rating_count', 'is_reviewed', 'is_favorite', 'favorites_count'];

    protected $hidden = ['name_en', 'name_ar', 'description_en', 'description_ar', 'created_at', 'updated_at'];

    public $timestamps = true;

    // appends attributes start
    public function getNameAttribute()
    {
        if (App::getLocale() == 'ar') {
            return $this->name_ar;
        }
        return $this->name_en;
    }

    public function getDescriptionAttribute()
    {
        if (App::getLocale() == 'ar') {
            return $this->description_ar;
        }
        return $this->description_en;
    }
    // appends attributes end

    // relations start
    public function accessories()
    {
        return $this->hasMany(Accessory::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function purchases()
    {
        return $this->hasMany(AccessoryStorePurchase::class,'accessories_store_id');
    }
    // relations end

    // Scopes start
    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function scopeAvailable($query)
    {
        return $query->where('available', 1);
    }

    public function scopeSearch($query)
    {

        $query->when(request()->search, function ($q) {
            return $q->where('name_ar', 'like', '%' . request()->search . '%')
                ->orWhere('name_en', 'like', '%' . request()->search . '%')
                ->orWhere('description_ar', 'like', '%' . request()->search . '%')
                ->orWhere('description_en', 'like', '%' . request()->search . '%');
        })->when(request()->city_id, function ($q) {
            return $q->where('city_id', request()->city_id);
        })->when(request()->brand_id, function ($q) {
            return $q->wherehas('accessories', function (Builder $query) {
                $query->whereHas('brand', function (Builder $query) {
                    return $query->where('brand_id', request()->brand_id);
                });
            });
        })->when(request()->car_model_id, function ($q) {
            return $q->wherehas('accessories', function (Builder $query) {
                $query->whereHas('car_model', function (Builder $query) {
                    return $query->where('car_model_id', request()->car_model_id);
                });
            });
        })->when(request()->category_id, function ($q) {
            return $q->wherehas('accessories', function (Builder $query) {
                $query->whereHas('category', function (Builder $query) {
                    return $query->where('category_id', request()->category_id);
                });
            });
        })->when(request()->sub_category_id, function ($q) {
            return $q->wherehas('accessories', function (Builder $query) {
                $query->whereHas('SubCategory', function (Builder $query) {
                    return $query->where('sub_category_id', request()->sub_category_id);
                });
            });
        });
    }
    //Scopes end

    // accessors & Mutator start
    public function getActive()
    {
        return $this->active == 1 ? __('words.active') : __('words.inactive');
    }

    public function getAvailable()
    {
        return $this->available == 1 ? __('words.available_prop') : __('words.not_available_prop');
    }

    public function getActiveNumberOfViews()
    {
        return $this->active_number_of_views == 1 ? __('words.active') : __('words.inactive');
    }

    public function getReservationAvailability()
    {
        return $this->reservation_availability == 1 ? __('words.available_prop') : __('words.not_available_prop');
    }

    public function getDeliveryAvailability()
    {
        return $this->delivery_availability == 1 ? __('words.available_prop') : __('words.not_available_prop');
    }

    public function getReservationActive()
    {
        return $this->reservation_active == 1 ? __('words.active') : __('words.inactive');
    }

    public function getDeliveryActive()
    {
        return $this->delivery_active == 1 ? __('words.active') : __('words.inactive');
    }

    public function getLogoAttribute($val)
    {
        return asset('uploads') . '/' . $val;
    }
    // accessors & Mutator end

}
