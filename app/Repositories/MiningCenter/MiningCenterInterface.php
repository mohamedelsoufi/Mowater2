<?php

namespace App\Repositories\MiningCenter;

interface MiningCenterInterface
{
    public function getAll();

    public function getCenterById($request);

    public function mawaterOffers($request);

    public function getServices();

    public function showService($request);
}
