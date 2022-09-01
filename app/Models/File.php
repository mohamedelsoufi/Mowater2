<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;
    protected $table = 'files';
    public $timestamps = true;
    protected $fillable = array('model_type', 'model_id', 'path', 'type','color_id');

    protected $hidden = ['created_at', 'updated_at'];

    //relationship start
    public function model()
    {
        return $this->morphTo();
    }

    public function color(){
        return $this->belongsTo(Color::class);
    }

    public function getPathAttribute($value)
    {
        return $value ? asset('uploads/' . $value) : null ;
    }


    //relationship end

}
