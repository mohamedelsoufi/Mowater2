<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class TrainingType extends Model
{
    use HasFactory;
    protected $table = 'training_types';
    protected $guarded = [];
    public $timestamps = false;
    protected $appends = ['no_of_sessions', 'category'];

    // appends start
    public function getNoOfSessionsAttribute()
    {
        return $this->no_of_hours / 2;
    }

    public function getCategoryAttribute()
    {
        if (App::getLocale() == 'ar') {
            return $this->category_ar;
        }
        return $this->category_en;
    }
    // appends end

    // relations start
    public function training_reservations()
    {
        return $this->belongsToMany(TrainingReservation::class);
    }

    public function trainers()
    {
        return $this->belongsToMany(DrivingTrainer::class, DrivingTrainerType::class);
    }
    // relations end

    // accessors & Mutator start
    public function getPriceAfterDiscount($id)
    {
        if ($this->discount != null) {
            $discount_type = $this->discount_type;
            $percentage_value = ((100 - $this->discount) / 100);

            $hour_price = $this->trainer()->find($id)->hour_price;
            $price = $hour_price * $this->no_of_hours;

            if ($discount_type == 'percentage') {
                return $price_after_discount = $price * $percentage_value;
            } else {
                return $price_after_discount = $price - $this->discount;

            }
        }
        return 0;
    }
    // accessors & Mutator end
}
