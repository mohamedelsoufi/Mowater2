<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Review extends Model
{
    use HasFactory;

    protected $table = 'reviews';
    public $timestamps = true;
    protected $fillable = array('reviewable_type', 'reviewable_id', 'user_id', 'rate', 'review');
    protected $hidden = ['updated_at'];

    //relationship start
    public function reviewable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    //relationship end
    public function getCreatedAtAttribute($value)
    {
        if($value)
        {
            return Carbon::parse($value)
                        ->format('Y-m-d h:i a');
        }
        else
        {
            return '';
        }
    }

}
