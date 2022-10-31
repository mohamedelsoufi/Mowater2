<?php

namespace App\Repositories\AccessoriesStore;

interface AccessoriesStoreInterface
{
    public function getAll();

    public function getStoreById($request);

    public function mawaterOffers($request);

    public function offers($request);

    public function getAccessories();

    public function showAccessory($request);

    public function purchase($request);

    public function getUserPurchases();

    public function ShowUserPurchase($request);
}
