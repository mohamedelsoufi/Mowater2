<?php

namespace App\Models;

use App\Traits\Ads\HasAds;
use App\Traits\Dayoffs\HasDayoffs;
use App\Traits\Favourites\CanBeFavourites;
use App\Traits\Files\HasFiles;
use App\Traits\OrganizationUsers\HasOrgUsers;
use App\Traits\PaymentMethods\HasPaymentMethods;
use App\Traits\Phones\HasPhones;
use App\Traits\Reviews\HasReviews;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Accessory extends Model
{
    use HasFactory, CanBeFavourites, HasReviews, HasDayoffs, HasAds,
        HasOrgUsers, HasPhones, HasPaymentMethods, HasFiles;

    protected $table = 'accessories';

    protected $fillable = ['id', 'accessories_store_id', 'name_en', 'name_ar', 'description_en',
        'description_ar', 'category_id', 'sub_category_id', 'brand_id', 'car_model_id', 'guarantee',
        'guarantee_year', 'guarantee_month', 'price', 'discount_type', 'discount', 'number_of_views',
        'active_number_of_views','available', 'active'];

    protected $appends = ['name', 'description', 'rating', 'rating_count', 'is_reviewed',
        'is_favorite', 'favorites_count', 'one_image', 'price_after_discount'];

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

    //relationship start
    public function accessoriesStore()
    {
        return $this->belongsTo(AccessoriesStore::class);
    }

    public function accessoryStorePurchases()
    {
        return $this->belongsToMany(AccessoryStorePurchase::class, 'accessory_store_purchase_accessories');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function SubCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function car_model()
    {
        return $this->belongsTo(CarModel::class);
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
    //Scopes end

    // accessors & Mutator start
    public function scopeSearch($query)
    {

        $query->when(request()->search, function ($q) {
            return $q->where('name_ar', 'like', '%' . request()->search . '%')
                ->orWhere('name_en', 'like', '%' . request()->search . '%')
                ->orWhere('description_ar', 'like', '%' . request()->search . '%')
                ->orWhere('description_en', 'like', '%' . request()->search . '%');
        })->when(request()->brand_id, function ($q) {
            return $q->where('brand_id', request()->brand_id);
        })->when(request()->car_model_id, function ($q) {
            return $q->where('car_model_id', request()->car_model_id);
        })->when(request()->category_id, function ($q) {
            return $q->where('category_id', request()->category_id);
        })->when(request()->sub_category_id, function ($q) {
            return $q->where('sub_category_id', request()->sub_category_id);
        })->when(request()->accessories_store_id, function ($q) {
            return $q->where('accessories_store_id', request()->accessories_store_id);
        });
    }

    public function getActive()
    {
        return $this->active == 1 ? __('words.active') : __('words.inactive');
    }

    public function getAvailable()
    {
        return $this->available == 1 ? __('words.available_prop') : __('words.not_available_prop');
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

    public function getOneImageAttribute()
    {
        $default_image = $this->files()->first();
        return $default_image ? $default_image->path : '';
    }
    // accessors & Mutator end

}
