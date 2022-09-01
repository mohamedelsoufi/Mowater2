<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class TrainingType extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;
    protected $appends = ['no_of_sessions', 'category'];

    public function getCategoryAttribute()
    {
        if (App::getLocale() == 'ar') {
            return $this->category_ar;
        }
        return $this->category_en;
    }

//relations
    public function training_reservations()
    {
        return $this->belongsToMany(TrainingReservation::class);
    }


    public function trainers()
    {
        return $this->belongsToMany(DrivingTrainer::class, DrivingTrainerType::class);
    }

    //appends
    public function getNoOfSessionsAttribute()
    {
        return $this->no_of_hours / 2;
    }
}
