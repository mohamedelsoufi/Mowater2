<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;

    protected $table = 'wallets';

    protected $guarded = [];

    protected $hidden = ['created_at', 'updated_at'];

    //relations
    public function user(){
        return $this->belongsTo(User::class);
    }

    // scopes
    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
