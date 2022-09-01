<?php

namespace App\Models;

use App\Traits\Ads\HasAds;
use App\Traits\Files\HasFiles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class TireExchangeCenterService extends Model
{
    use HasFactory, HasFiles, HasAds;

    protected $table = 'tire_exchange_center_services';

    protected $fillable = ['id', 'tire_exchange_center_id', 'name_en', 'name_ar', 'description_en'
        , 'description_ar', 'number_of_views','active_number_of_views', 'price', 'discount', 'discount_type', 'available', 'active'];

    protected $appends = ['name', 'description', 'one_image', 'price_after_discount'];

    protected $hidden = ['name_ar', 'name_en', 'description_ar', 'description_en', 'created_at', 'updated_at'];

    public $timestamps = true;

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

    //relationship start
    public function tireExchangeCenter()
    {
        return $this->belongsTo(TireExchangeCenter::class, 'tire_exchange_center_id');
    }

    public function offers()
    {
        return $this->morphMany(Offer::class, 'offerable');
    }
    //relationship end

    //Scopes start
    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function scopeAvailable($query)
    {
        return $query->where('available', 1);
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

    public function getOneImageAttribute()
    {
        $default_image = $this->files()->first();
        return $default_image ? $default_image->path : '';
    }
    // accessors & Mutator end
}

