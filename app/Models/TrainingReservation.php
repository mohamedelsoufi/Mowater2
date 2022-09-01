<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ReservationSession;

class TrainingReservation extends Model
{
    use HasFactory;
    protected $table = 'driving_trainers_reservations';
    protected $guarded = [];
    public $timestamps = true;

    //relations

    public function trainer()
    {
        return $this->belongsTo(DrivingTrainer::class,'driving_trainer_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reservation_sessions()
    {
        return $this->hasMany(ReservationSession::class, 'reservation_id');
    }

    public function training_type()
    {
        return $this->belongsTo(TrainingType::class,'training_type_id');
    }

    //scopes
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

}
