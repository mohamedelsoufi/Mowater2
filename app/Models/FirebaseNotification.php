<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FirebaseNotification extends Model
{
    use HasFactory;
    protected $table = 'firebase_notifications';
    protected $fillable = ['id', 'user_id', 'firebase_token', 'platform'];
    protected $hidden = ['created_at', 'updated_at'];

    //relationship start
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    //relationship end
}
