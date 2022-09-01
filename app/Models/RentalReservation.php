<?php

namespace App\Models;

use App\Traits\Files\HasFiles;
use App\Traits\PaymentMethods\HasPaymentMethods;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentalReservation extends Model
{
    use HasFactory, HasPaymentMethods, HasFiles;
    protected $table = 'rental_reservations';
    public $timestamps = true;
    protected $guarded = [];
    protected $hidden = ['created_at', 'updated_at'];

    //relationship start
    public function rental_office_car()
    {
        return $this->belongsTo('App\Models\RentalOfficeCar');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    //relationship end

    public function setAddressAttribute($val)
    {
        $this->attributes['address'] = ucfirst($val);
    }

    public function setFirstNameAttribute($val)
    {
        $this->attributes['first_name'] = ucwords($val);
    }

    public function setLastNameAttribute($val)
    {
        $this->attributes['last_name'] = ucfirst($val);
    }

    public function setNickNameAttribute($val)
    {
        $this->attributes['nickname'] = ucfirst($val);
    }

    public function getCarNameAttribute()
    {
        $brand = $this->rental_office_car && $this->rental_office_car->car_model && $this->rental_office_car->car_model->brand ? $this->rental_office_car->car_model->brand : '';
        $car_model = $this->rental_office_car && $this->rental_office_car->car_model ? $this->rental_office_car->car_model->name : '';
        $car_class = $this->rental_office_car && $this->rental_office_car->car_class ? $this->rental_office_car->car_class->name : '';

        $manufacture_year = $this->rental_office_car ? $this->rental_office_car->manufacture_year : '';

        $name = $car_model . ' - ' . $manufacture_year . ' - ' . $car_class;

        return $name;

    }
}
