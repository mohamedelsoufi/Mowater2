<?php

namespace App\Models;

use App\Traits\Files\HasFiles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestProduct extends Model
{
    use HasFactory, HasFiles;
    protected $table = 'request_products';
    protected $fillable = array('brand_id', 'car_model', 'user_id', 'manufacturing_year', 'category_id', 'type', 'is_new', 'vehicle_number');
    protected $appends = ['one_image'];

    public function scraps()
    {
        return $this->morphedByMany(Scrap::class, 'organizationable', 'request_product_organization')->withPivot('status', 'price');
    }
    public function spare_parts()
    {
        return $this->morphedByMany(SparePart::class, 'organizationable', 'request_product_organization')->withPivot('status', 'price');
    }

//    public function products()
//    {
//        return $this->hasMany(Product::class);
//    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }


    public function getOneImageAttribute()
    {
        $default_image = $this->files()->first();
        return $default_image ? $default_image->path : null;
        //return $default_image ? asset('uploads/' . $default_image->path) : null;
    }

    public function getIsNew()
    {
        return $this->is_new == 1 ? __('words.new') : __('words.used');
    }


    public function getStatus()
    {
        return $this->status == '' ? __('words.not_mentioned') : $this->status;
    }
}
