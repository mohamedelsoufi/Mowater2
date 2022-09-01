<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryManCategory extends Model
{
    use HasFactory;

    protected $table ='delivery_man_categories';

    protected $guarded = [];

    public $timestamps = true;

    public function offers()
    {
        return $this->morphMany(Offer::class, 'offerable');
    }

    public function delivery_men()
    {
        return $this->belongsTo(DeliveryMan::class,'delivery_man_id');
    }

    public function categories()
    {
        return $this->belongsTo(Category::class,'category_id');
    }

}
