<?php

namespace App\Models;

use App\Traits\Ads\HasAds;
use App\Traits\Categories\InCategories;
use App\Traits\Contacts\HasContacts;
use App\Traits\Dayoffs\HasDayoffs;
use App\Traits\Favourites\CanBeFavourites;
use App\Traits\OrganizationDiscountCards\HasOrganizationDiscountCard;
use App\Traits\OrganizationUsers\HasOrgUsers;
use App\Traits\PaymentMethods\HasPaymentMethods;
use App\Traits\Products\HasProducts;
use App\Traits\Reservations\CanBeReserved;
use App\Traits\Reviews\HasReviews;
use App\Traits\Services\HasServices;
use App\Traits\WorkTimes\HasWorkTimes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;
use App\Traits\Phones\HasPhones;

class Garage extends Model
{
    use HasFactory, CanBeFavourites, InCategories, HasWorkTimes,
        HasServices, HasProducts, HasContacts, HasDayoffs, CanBeReserved, HasReviews, HasAds, HasOrgUsers ,
        HasPhones,HasOrganizationDiscountCard,HasPaymentMethods;

    protected $table = 'garages';
    public $timestamps = true;
    protected $guarded = [];

    protected $hidden = ['name_ar', 'name_en', 'description_ar', 'description_en', 'created_at', 'updated_at'];

    protected $appends = ['name', 'description', 'rating', 'rating_count', 'is_reviewed', 'is_favorite','favorites_count'];

    //// appends attributes start //////
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
    //// appends attributes end //////

    /// relations
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


    //    Scopes
    public function available_reservation(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:garages,id',
//                'date' => 'required|date'
            ]);
            if ($validator->fails())
                return responseJson(0, $validator->errors()->first(), $validator->errors());
            $day = date("D", strtotime($request->date));

            $garage = Garage::with(['work_time', 'day_offs'])->find($request->id);


            $day_offs = $garage->day_offs()->where('date', $request->date)->get();
            foreach ($day_offs as $day_off) {
                if ($day_off)
                    return [];
            }
            $find_day = array_search($day, $garage->work_time->days);


            if ($find_day !== false) {

                $module = $garage->work_time;

                $available_times = [];

                $from = date("H:i", strtotime($module->from));
                $to = date("H:i", strtotime($module->to));


                if (!in_array(date("h:i a", strtotime($from)), $available_times)) {
                    array_push($available_times, date("h:i a", strtotime($from)));
                }

                $time_from = strtotime($from);

                $new_time = date("H:i", strtotime($module->duration . ' minutes', $time_from));
                if (!in_array(date("h:i a", strtotime($new_time)), $available_times)) {
                    array_push($available_times, date("h:i a", strtotime($new_time)));
                }

                while ($new_time < $to) {
                    $time = strtotime($new_time);
                    $new_time = date("H:i", strtotime($module->duration . ' minutes', $time));
                    if ($new_time . ':00' >= $to) {
                        break;
                    }

                    if (!in_array(date("h:i a", strtotime($new_time)), $available_times)) {
                        array_push($available_times, date("h:i a", strtotime($new_time)));
                    }

                    $reservations = $garage->reservations;
                    foreach ($reservations as $key => $reservation) {
                        if ($reservation->date == $request->date) {
                            $formated = date("h:i a", strtotime($reservation->time));

                            if (($key = array_search($formated, $available_times)) !== false) {
                                unset($available_times[$key]);
                            }
                        }
                    }
                }

                return array_values($available_times);
            }
        } catch (\Exception $e) {
            return array('error : ' . $e->getMessage());
        }
    }

    public function getActive()
    {
        return $this->active == 1 ? __('words.active') : __('words.inactive');
    }

    public function getAvailable()
    {
        return $this->available == 1 ? __('words.available_prop') : __('words.not_available_prop');
    }

    public function getReservation_availability()
    {
        return $this->reservation_availability == 1 ? __('words.available_prop') : __('words.not_available_prop');
    }

    public function getDelivery_availability()
    {
        return $this->delivery_availability == 1 ? __('words.available_prop') : __('words.not_available_prop');
    }

    public function getReservation_active()
    {
        return $this->reservation_active == 1 ? __('words.available_prop') : __('words.not_available_prop');
    }

    public function getDelivery_active()
    {
        return $this->delivery_active == 1 ? __('words.available_prop') : __('words.not_available_prop');
    }

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
        return $query->select('id', 'name_en', 'name_ar', 'description_en', 'description_ar',
            'tax_number', 'logo', 'reservation_availability', 'delivery_availability', 'reservation_active',
            'delivery_active', 'country_id', 'city_id', 'area_id', 'year_founded','number_of_views');
    }

    public function scopeSearch($query)
    {
        $query->when(request()->search, function ($q) {
            return $q->where('name_ar', 'like', '%' . request()->search . '%')
                ->orWhere('name_en', 'like', '%' . request()->search . '%')
                ->orWhere('description_ar', 'like', '%' . request()->search . '%')
                ->orWhere('description_en', 'like', '%' . request()->search . '%');
        })->when(request()->country, function ($q) {
            return $q->where('country_id', request()->country);
        })->when(request()->city, function ($q) {
            return $q->where('city_id', request()->city);
        })->when(request()->area, function ($q) {
            return $q->where('area_id', request()->area);
        })->when(request()->category_id, function ($q) {
            return $q->wherehas('categories', function (Builder $query) {
                $query->where('category_id', request()->category_id);
            });
        })->when(request()->sub_category_id, function ($q) {
            return $q->wherehas('categories', function (Builder $query) {
                $query->wherehas('sub_categories', function (Builder $qu){
                   $qu->where('id',request()->sub_category_id);
                });
            });
        });
    }

    public function getLogoAttribute($val)
    {
        return asset('uploads') . '/' . $val;
    }

}

