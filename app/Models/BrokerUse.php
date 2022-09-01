<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrokerUse extends Model
{
    use HasFactory;

    protected $table = 'broker_uses';

    protected $guarded = [];

    public $timestamps = true;

    public function offers()
    {
        return $this->morphMany(Offer::class, 'offerable');
    }
}
