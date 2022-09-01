<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class SubCategory extends Model
{
    use HasFactory;
    protected $table = 'sub_categories';
    protected $fillable = ['id', 'name_en', 'name_ar', 'category_id'];
    protected $hidden = ['name_en', 'name_ar', 'created_at', 'updated_at'];
    protected $appends = ['name'];
    public $timestamps = true;

    // appends attributes start
    public function getNameAttribute()
    {
        if (App::getLocale() == 'ar') {
            return $this->name_ar;
        }
        return $this->name_en;
    }
    // appends attributes end

    // relationship start
    public function category(){
        return $this->belongsTo(Category::class);
    }
    // relationship end

    // accessors & Mutator start
    public function setNameEnAttribute($val)
    {
        $this->attributes['name_en'] = ucwords($val);
    }
    // accessors & Mutator end
}
