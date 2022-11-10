<?php

namespace App\Models;

use App\Traits\Ads\HasAds;
use App\Traits\Contacts\HasContacts;
use App\Traits\Dayoffs\HasDayoffs;
use App\Traits\Favourites\CanBeFavourites;
use App\Traits\Files\HasFiles;
use App\Traits\OrganizationDiscountCards\HasOrganizationDiscountCard;
use App\Traits\OrganizationUsers\HasOrgUsers;
use App\Traits\PaymentMethods\HasPaymentMethods;
use App\Traits\Reservations\CanBeReserved;
use App\Traits\Reviews\HasReviews;
use App\Traits\WorkTimes\HasWorkTimes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Traits\Phones\HasPhones;
use DateTime;

class DrivingTrainer extends Model
{
    use HasFactory, HasOrgUsers, HasFiles, CanBeReserved, HasWorkTimes, HasDayoffs, HasReviews,
        CanBeFavourites, HasAds, HasPhones, HasOrganizationDiscountCard, HasPaymentMethods, HasContacts;
    protected $guarded = [];
    protected $hidden = ['name_en', 'name_ar', 'description_en', 'description_ar', 'profile_picture', 'created_at', 'updated_at', 'notes'];
    protected $appends = ['name', 'description', 'price_after_discount', 'is_reviewed', 'rating', 'rating_count', 'is_favorite',
        'favorites_count', 'profile', 'age','training_license','vehicle_image'];

    // appends start
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

//    public function getConveyorTypeAttribute()
//    {
//        return $this->attributes['conveyor_type'] == 'automatic' ? __('words.automatic') : __('words.manual');
//    }
    // appends end

    // relations start
    public function roles(){
        return $this->morphMany(Role::class,'rolable');
    }

    public function reservations()
    {
        return $this->hasMany(TrainingReservation::class);
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

    public function types()
    {
        return $this->belongsToMany(TrainingType::class, DrivingTrainerType::class);
    }

    public function conditions(){
        return $this->morphMany(Condition::class,'conditionable');
    }

    public function offers()
    {
        return $this->morphMany(Offer::class, 'offerable');
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

    public function scopeSelection($query)
    {
        return $query->select('id', 'name_ar', 'name_en', 'gender', 'description_en', 'description_ar', 'birth_date', 'conveyor_type', 'vehicle_type', 'brand_id', 'car_class_id', 'car_model_id', 'manufacturing_year', 'hour_price',
            'country_id', 'city_id', 'area_id', 'number_of_views', 'active_number_of_views');
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
        })->when(request()->manufacturing_year, function ($q) {
            return $q->where('manufacturing_year', request()->manufacturing_year);
        })->when(request()->gender, function ($q) {
            return $q->where('gender', request()->gender);
        })->when(request()->vehicle_type, function ($q) {
            return $q->where('vehicle_type', request()->vehicle_type);
        })->when(request()->conveyor_type, function ($q) {
            return $q->where('conveyor_type', request()->conveyor_type);
        });
    }

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

    public function getTrainingLicenseAttribute()
    {
        return $this->files()->where('type','training_license')->first() ? $this->files()->where('type','training_license')->first()->path : asset('uploads/default_image.png');
    }

    public function getVehicleImageAttribute()
    {
        return $this->files()->where('type','trainer_vehicle')->first() ? $this->files()->where('type','trainer_vehicle')->first()->path : asset('uploads/default_image.png');
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

    public function available_reservation(Request $request)
    {

        try {
            $day = date("D", strtotime($request->date));
            $available_times = [];

            $trainer = DrivingTrainer::with(['work_time', 'day_offs'])->find($request->id);
            if (date('Y-m-d', strtotime($request->date)) <= \Carbon\Carbon::yesterday()->format('Y-m-d')) {
                return responseJson(0, __('message.requested_date') . $request->date . ' ' . __('message.date_is_old'));
            }

            if (isset($trainer->day_offs)) {
                $day_offs = $trainer->day_offs()->where('date', $request->date)->get();
                foreach ($day_offs as $day_off) {
                    if ($day_off)
                        return $available_times;
                }
            }

            $find_day = in_array($day, $trainer->work_time->days);
//            return $find_day;
            if ($find_day !== false) {

                $module = $trainer->work_time;

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

                    $reservations = $trainer->reservations;
                    foreach ($reservations as $key => $reservation) {
                        foreach ($reservation->reservation_sessions as $session) {
                            if ($session->date == $request->date) {
                                $formated = date("h:i a", strtotime($session->time));

                                if (($key = array_search($formated, $available_times)) !== false) {
                                    unset($available_times[$key]);
                                }
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

    public function getPriceAfterDiscountAttribute()
    {
        if ($this->discount != null) {
            $discount_type = $this->discount_type;
            $percentage_value = ((100 - $this->discount) / 100);
            if ($discount_type == 'percentage') {
                return $price_after_discount = number_format($this->hour_price * $percentage_value,2);
            } else {
                return $price_after_discount = number_format($this->hour_price - $this->discount,2);

            }
        }
        return 0;
    }
    // accessors & Mutator  end
}
