<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Carbon;

class DiscountCardUser extends Pivot
{
    use HasFactory;
    protected $table = 'discount_card_users';
    protected $fillable = ['id', 'discount_card_id', 'user_id', 'barcode', 'vehicles', 'price', 'created_at'];
    protected $hidden = ['created_at', 'updated_at'];
    public $timestamps = true;


//    public function setCreatedAtAttribute($value)
//    {
//        $this->attributes['created_at'] = \Carbon\Carbon::now();
//    }

//    public function getCreatedAtAttribute($value)
//    {
//        return $this->attributes['created_at'] = Carbon::createFromFormat('Y-m-d H:i:s', $value)->format('d-m-Y H:i A');
//    }
}
