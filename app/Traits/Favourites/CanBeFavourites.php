<?php


namespace App\Traits\Favourites;
use Illuminate\Support\Facades\Auth;

trait CanBeFavourites
{
    public function favourites()
    {
        return $this->morphToMany('App\Models\User', 'favourable');
    }

    public function getFavoritesCountAttribute()
    {
        return $this->favourites()->count();
    }

    public function attachFavourite()
    {
        $user = auth('api')->user();

        if($user)
        {
            if (!$this->favourites()->where('user_id', $user->id)->exists()) {
                $this->favourites()->attach($user->id);
            }
        }

    }

    public function detachFavourite()
    {
        $user = auth('api')->user();
        if($user)
        {
            $this->favourites()->detach($user->id);
        }

    }

    public function getIsFavoriteAttribute()
    {
        if(Auth::guard('api')->check())
        {
            $user = Auth::guard('api')->user();

            return $this->favourites()->where('user_id' , $user->id)->exists();
        }
        return false;

    }

}
