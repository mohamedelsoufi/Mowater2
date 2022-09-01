<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorizable extends Model
{
    use HasFactory;

    protected $table = 'categorizables';

    protected $guarded = [];

    public function offers()
    {
        return $this->morphMany(Offer::class, 'offerable');
    }
}
