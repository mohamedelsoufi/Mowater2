<?php

namespace App\Models;

use App\Traits\Files\HasFiles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory, HasFiles;
    protected $table = 'sliders';
    public $timestamps = true;
    protected $fillable = array('id','section_id', 'type');
    protected $hidden = ['created_at', 'updated_at'];

    //relationship start
    public function section()
    {
        return $this->belongsTo('App\Models\Section');
    }
    //relationship end

    public function getOneImageAttribute()
    {
        $default_image = $this->files()->first();
        return $default_image ? asset($default_image->path) : null ;
    }

}
