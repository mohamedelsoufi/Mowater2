<?php


namespace App\Traits\Categories;

trait InCategories
{

    public function categories()
    {
        return $this->morphToMany('App\Models\Category', 'categorizable');
    }

}
