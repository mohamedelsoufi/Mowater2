<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Verification extends Model
{
    use HasFactory;

    protected $table = 'verifications';
    public $timestamps = true;
    protected $fillable = array('id', 'model_type', 'model_id', 'user_id ', 'status', 'created_at', 'updated_at');

    protected $hidden = ['created_at', 'updated_at'];

    public function model(){
        return $this->morphTo();
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
