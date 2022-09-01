<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    use HasFactory;
    protected $table = 'phones';
    public $timestamps = true;
    protected $fillable = array('phoneable_type', 'phoneable_id', 'country_code','phone' , 'title_en' , 'title_ar');
    protected $hidden = ['created_at', 'updated_at'];
    protected $appends = ['title'];

    //relationship start
    public function phoneable()
    {
        return $this->morphTo();
    }

    public function getTitleAttribute()
    {
        return app()->getLocale() == 'ar' ? $this->title_ar : $this->title_ar;
    }
    //relationship end

}
