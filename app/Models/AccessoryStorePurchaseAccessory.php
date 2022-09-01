<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccessoryStorePurchaseAccessory extends Model
{
    use HasFactory;

    protected $table = 'accessory_store_purchase_accessories';

    protected $fillable = ['id', 'accessory_store_purchase_id'];

    protected $hidden = ['created_at', 'updated_at'];

    public $timestamps = true;

    //relationship start
    public function accessory_store_purchase()
    {
        return $this->belongsTo(AccessoryStorePurchase::class);
    }

    public function accessories()
    {
        return $this->belongsTo(Accessory::class);
    }
    //relationship end
}
