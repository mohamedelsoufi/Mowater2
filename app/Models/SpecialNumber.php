<?php

namespace App\Models;

use App\Traits\Ads\HasAds;
use App\Traits\Favourites\CanBeFavourites;
use App\Traits\PaymentMethods\HasPaymentMethods;
use App\Traits\Reviews\HasReviews;
use App\Traits\Verifications\HasVerfications;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpecialNumber extends Model
{
    use HasFactory, HasVerfications, HasReviews, CanBeFavourites, HasAds,HasPaymentMethods;
    protected $table = 'special_numbers';
    public $timestamps = true;
    protected $guarded = [];
    protected $hidden = ['created_at', 'updated_at', 'rating', 'rating_count', 'is_reviewed', 'is_favorite','favorites_count', 'Include_insurance'];
    protected $appends = ['price_after_discount'];

    // relationship start
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function sub_category()
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function special_number_organization()
    {
        return $this->belongsTo(SpecialNumberOrganization::class);
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function offers()
    {
        return $this->morphMany(Offer::class, 'offerable');
    }
    // relationship end


    // scopes start
    public function scopeAvailability($query)
    {
        return $query->where('availability', 1);
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function scopeSorting($query)
    {
        if (request()->has('newest')) {
            $query->orderBy('id', 'desc')->get();
        } elseif (request()->has('oldest')) {
            $query->orderBy('id', 'asc')->get();
        } elseif (request()->has('highest')) {
            $query->orderBy('price', 'desc')->get();
        } elseif (request()->has('lowest')) {
            $query->orderBy('price', 'asc')->get();
        }
    }

    public function scopeSelection($query)
    {
        return $query->select('id', 'category_id', 'number', 'size', 'transfer_type', 'price',
            'user_id', 'special_number_organization_id', 'price_include_transfer', 'number_of_views');
    }

    public function scopeSearch($query)
    {
        $query->where(function ($q) {
            if (request()->filled('is_special')) {
                $q->where('is_special', request()->is_special);
            }
        })->when(request()->number, function ($q) {
            $q->where('number', 'like', '%' . request()->number . '%');
        })->when(request()->number_start_with, function ($q) {
            $q->where('number', 'like', request()->number_start_with . '%');
        })->when(request()->transfer_type, function ($q) {
            $q->where('transfer_type', 'like', '%' . request()->transfer_type . '%');
        })->when(request()->price, function ($q) {
            $q->where('price', request()->price);
        })->when(request()->size, function ($q) {
            $q->where('size', request()->size);
        })->when(request()->organization, function ($q) {
            $q->where('special_number_organization_id', request()->organization);
        })->when(request()->user, function ($q) {
            $q->where('user_id', request()->user);
        })->when(request()->category_id, function ($q) {
            return $q->wherehas('category', function (Builder $query) {
                $query->where('id', request()->category_id);
            });
        })->when(request()->sub_category_id, function ($q) {
            return $q->wherehas('sub_category', function (Builder $query) {
                $query->where('id', request()->sub_category_id);
            });
        })->when(request()->number, function ($q) {
            $q->where('number', 'like', '%' . request()->number . '%');
        });
    }
    // scopes end

    // accessors & Mutator start
    public function getSizeAttribute($val)
    {

        return $val === 'normal_plate' ? __('words.normal_plate') : __('words.special_plate');
    }

    public function getTransferTypeAttribute($val)
    {

        return $val === 'own' ? __('words.own') : __('words.waiver');
    }

    public function getAvailable()
    {
        return $this->availability == 1 ? __('words.available_prop') : __('words.not_available_prop');
    }

    public function getActive()
    {
        return $this->active == 1 ? __('words.active') : __('words.inactive');
    }

    public function getActiveNumberOfViews()
    {
        return $this->active_number_of_views == 1 ? __('words.active') : __('words.inactive');
    }

    public function getIncludeInsurance()
    {
        return $this->Include_insurance == 1 ? __('words.including') : __('words.excl');
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
