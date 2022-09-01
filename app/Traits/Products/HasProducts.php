<?php


namespace App\Traits\Products;

use App\Models\Product;

trait HasProducts
{
    public function products()
    {
        return $this->morphMany(Product::class, 'productable');
    }

}
