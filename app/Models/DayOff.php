<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DayOff extends Model
{
    use HasFactory;
    protected $table = 'day_offs';
    public $timestamps = true;
    protected $fillable = array('model_type', 'model_id', 'date', 'from', 'to','created_by');
    protected $hidden = ['created_at', 'updated_at'];

    //relationship start
    public function model()
    {
        return $this->morphTo();
    }
    //relationship end

}
