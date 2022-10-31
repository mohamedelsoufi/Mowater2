<?php
namespace App\Traits\products_requests;

use App\Models\RequestProduct;

trait HasProductsRequests
{
    public function request_product_organizations()
    {
        return $this->morphToMany(RequestProduct::class, 'organizationable', 'request_product_organization')->withPivot('status', 'price');
    }
}

?>
