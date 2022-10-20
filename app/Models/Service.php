<?php

namespace App\Models;

use App\Traits\Ads\HasAds;
use App\Traits\Files\HasFiles;
use App\Traits\Reservations\CanBeReserved;
use App\Traits\Verifications\HasVerfications;
use App\Traits\WorkTimes\HasWorkTimes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Service extends Model
{
    use HasFactory, HasVerfications, CanBeReserved, HasFiles, HasWorkTimes, HasAds;
    protected $table = 'services';
    public $timestamps = true;
    protected $guarded = [];
    protected $hidden = ['name_ar', 'name_en', 'description_ar', 'description_en', 'created_at', 'updated_at'];

    protected $appends = ['name', 'description', 'one_image', 'price_after_discount'];

    // appends attributes start
    public function getNameAttribute()
    {
        if (App::getLocale() == 'ar')
            return $this->name_ar;
        return $this->name_en;
    }

    public function getDescriptionAttribute()
    {
        if (App::getLocale() == 'ar')
            return $this->description_ar;
        return $this->description_en;
    }
    // appends attributes end

    // relations start
    public function servable()
    {
        return $this->morphTo();
    }

    public function branches()
    {
        return $this->morphToMany('App\Models\Branch', 'usable');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function reservations()
    {
        return $this->belongsToMany(Reservation::class, 'reservation_service');
    }

    public function offers()
    {
        return $this->morphMany(Offer::class, 'offerable');
    }

    public function trafficClearingOfficeRequests()
    {
        return $this->hasMany(TrafficClearingOfficeRequest::class);
    }
    // relations start

    // Scopes start
    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function scopeAvailable($query)
    {
        return $query->where('available', 1);
    }

    public function scopeSelection($query)
    {
        return $query->select('id', 'name_en', 'name_ar', 'description_en', 'description_ar', 'servable_type', 'servable_id', 'category_id',
            'discount', 'discount_type', 'active', 'available', 'price', 'location_required', 'number_of_views','active_number_of_views');
    }
    //Scopes end

    // accessors & Mutator start
    public function get_offer($discount_card_id)
    {
        return $this->offers()->where('offers.discount_card_id', $discount_card_id)->first();
    }

    public function getOneImageAttribute()
    {
        $default_image = $this->files()->first();
        return $default_image ? $default_image->path : null;
    }

    public function getLocationRequired()
    {
        return $this->location_required == 1 ? __('words.required') : __('words.not_required');
    }

    public function getAvailability()
    {
        return $this->available == 1 ? __('words.available_prop') : __('words.not_available_prop');
    }

    public function getActive()
    {
        return $this->active == 1 ? __('words.active') : __('words.inactive');
    }

    public function getActiveNumberOfViews()
    {
        return $this->active_number_of_views == 1 ? __('words.active') : __('words.inactive');
    }

    public function getPriceAfterDiscountAttribute()
    {
        if ($this->discount != null) {
            $discount_type = $this->discount_type;
            $percentage_value = ((100 - $this->discount) / 100);
            if ($discount_type == 'percentage') {
                return $price_after_discount = $this->price * $percentage_value;
            } else {
                return $price_after_discount = $this->price - $this->discount;

            }
        }
        return 0;
    }
    // accessors & Mutator end
}
