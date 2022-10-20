<?php

namespace App\Models;

use App\Traits\Ads\HasAds;
use App\Traits\Contacts\HasContacts;
use App\Traits\Dayoffs\HasDayoffs;
use App\Traits\Favourites\CanBeFavourites;
use App\Traits\Files\HasFile;
use App\Traits\Files\HasFiles;
use App\Traits\OrganizationDiscountCards\HasOrganizationDiscountCard;
use App\Traits\OrganizationUsers\HasOrgUsers;
use App\Traits\PaymentMethods\HasPaymentMethods;
use App\Traits\Reviews\HasReviews;
use App\Traits\WorkTimes\HasWorkTimes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Traits\Phones\HasPhones;
use DateTime;
use Illuminate\Support\Facades\Validator;

class DeliveryMan extends Model
{
    use HasFactory, HasFile, HasOrgUsers, HasWorkTimes, HasDayoffs, HasReviews, CanBeFavourites,
        HasAds, HasPhones, HasOrganizationDiscountCard,HasPaymentMethods, HasContacts,HasFiles;
    protected $table = 'delivery_man';
    protected $guarded = [];
    protected $hidden = ['name_ar', 'name_en', 'description_ar', 'description_en', 'created_at', 'updated_at'];
    protected $appends = ['name', 'description', 'is_reviewed', 'rating', 'rating_count', 'is_favorite','favorites_count', 'profile', 'file_url', 'age'];

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
    public function roles(){
        return $this->morphMany(Role::class,'rolable');
    }

    public function reservations()
    {
        return $this->hasMany(DeliveryManReservation::class);
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

    public function brand()
    {
        return $this->belongsTo('App\Models\Brand');
    }

    public function car_model()
    {
        return $this->hasOne(CarModel::class, 'id', 'car_model_id');
    }

    public function car_class()
    {
        return $this->hasOne(CarClass::class, 'id', 'car_class_id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, DeliveryManCategory::class);
    }

    public function conditions(){
        return $this->morphMany(Condition::class,'conditionable');
    }

    public function deliveryAreas(){
        return $this->hasMany(DeliveryArea::class,'delivery_man_id');
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
                ->orWhere('name_ar', 'like', '%' . request()->search . '%')
                ->orWhere('name_en', 'like', '%' . request()->search . '%')
                ->orWhere('description_en', 'like', '%' . request()->search . '%')
                ->orWhere('description_ar', 'like', '%' . request()->search . '%');
        })->when(request()->country, function ($q) {
            return $q->where('country_id', request()->country);
        })->when(request()->city, function ($q) {
            return $q->where('city_id', request()->city);
        })->when(request()->area, function ($q) {
            return $q->where('area_id', request()->area);
        })->when(request()->vehicle_type, function ($q) {
            return $q->where('vehicle_type', 'like', '%' . request()->vehicle_type . '%');
        })->when(request()->manufacturing_year, function ($q) {
            return $q->where('manufacturing_year', request()->manufacturing_year);
        })->when(request()->gender, function ($q) {
            return $q->where('gender', request()->gender);
        })->when(request()->category_id, function ($q) {
            return $q->whereHas('categories', function (Builder $query){
                 $query->where('category_id',request()->category_id);
            });
        })->when(request()->brand_id, function ($q) {
            return $q->where('brand_id', request()->brand_id);
        })->when(request()->car_model_id, function ($q) {
            return $q->where('car_model_id', request()->car_model_id);
        })->when(request()->car_class_id, function ($q) {
            return $q->where('car_class_id', request()->car_class_id);
        })->when(request()->status, function ($q) {
            return $q->where('status', request()->status);
        });
    }

    public function available_reservation(Request $request)
    {

        try {
            $day = date("D", strtotime($request->day_to_go));
            $available_times = [];

            $man = DeliveryMan::with(['work_time', 'day_offs'])->find($request->delivery_man_id);
            if (date('Y-m-d', strtotime($request->day_to_go)) <= \Carbon\Carbon::yesterday()->format('Y-m-d')) {
                return responseJson(0, __('message.requested_date') . $request->date . ' ' . __('message.date_is_old'));
            }

            if (isset($man->day_offs)) {
                $day_offs = $man->day_offs()->where('date', $request->day_to_go)->get();
                foreach ($day_offs as $day_off) {
                    if ($day_off)
                        return $available_times;
                }
            }

            $find_day = in_array($day, $man->work_time->days);
//            return $find_day;
            if ($find_day !== false) {

                $module = $man->work_time;

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

                    $reservations = $man->reservations;
                    foreach ($reservations as $key => $reservation) {
                        if ($reservation->day_to_go == $request->day_to_go) {
                            $formated = date("h:i a", strtotime($reservation->time));

                            if (($key = array_search($formated, $available_times)) !== false) {
                                unset($available_times[$key]);
                            }
                        }
                    }
                }
                return array_values($available_times);
            } else {
                return $available_times;

            }
        } catch (\Exception $e) {
            return array('error : ' . $e->getMessage());
        }
    }
    // Scopes end

    // accessors & Mutator start
    public function getAgeAttribute()
    {
        $bday = new DateTime($this->birth_date); // Your date of birth
        $today = new Datetime();
        $diff = $today->diff($bday);
        return $diff->y;
    }

    public function getProfileAttribute()
    {
        $model = $this->find($this->id);
        return $model->profile_picture ? asset('uploads') . '/' . $model->profile_picture : asset('no-user.jpg');
    }

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

    public function getStatusAttribute()
    {
        if ($this->attributes['status'] == 'available')
            return __('words.available_prop');
        if ($this->attributes['status'] == 'busy')
            return __('words.busy');
        if ($this->attributes['status'] == 'not_available')
            return __('words.not_available_prop');

    }
    // accessors & Mutator  end

}
