<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkTime extends Model
{
    use HasFactory;
    protected $table = 'work_times';
    public $timestamps = true;
    protected $fillable = array('workable_type', 'workable_id', 'from', 'to', 'duration', 'days');
    protected $hidden = ['created_at', 'updated_at'];

    //relationship start
    public function workable()
    {
        return $this->morphTo();
    }

    public function getDaysAttribute($val)
    {
        return explode(",", $val);
        //return $this->attributes['days'] = explode(",", $val);
    }
    //relationship end

}
