<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TrainingReservation;

class ReservationSession extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'reservation_sessions';
    protected $fillable = ['id', 'reservation_id', 'time', 'date'];

//
//    public function reservation()
//    {
//        return $this->belongsTo(TrainingReservation::class);
//    }
}
