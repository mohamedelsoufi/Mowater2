<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DrivingTrainerType extends Model
{
    use HasFactory;

    protected $table = 'driving_trainer_types';

    protected $guarded = [];

    public $timestamps = true;

    // relations start
    public function trainer()
    {
        return $this->belongsTo(DrivingTrainer::class,'driving_trainer_id');
    }

    public function training_type()
    {
        return $this->belongsTo(TrainingType::class,'training_type_id');
    }
    // relations end

}
