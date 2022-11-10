<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryManCategory extends Model
{
    use HasFactory;

    protected $table = 'delivery_man_categories';

    protected $guarded = [];

    protected $appends = ['price_after_discount'];


    public $timestamps = true;

    public function offers()
    {
        return $this->morphMany(Offer::class, 'offerable');
    }

    public function delivery_men()
    {
        return $this->belongsTo(DeliveryMan::class, 'delivery_man_id');
    }

    public function categories()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }


    public function getPriceAfterDiscountAttribute()
    {
        if ($this->discount != null) {
            $discount_type = $this->discount_type;
            $percentage_value = ((100 - $this->discount) / 100);
            if ($discount_type == 'percentage') {
                return $price_after_discount = number_format($this->price * $percentage_value,2);
            } else {
                return $price_after_discount = number_format($this->price - $this->discount,2);

            }
        }
        return 0;
    }

}
