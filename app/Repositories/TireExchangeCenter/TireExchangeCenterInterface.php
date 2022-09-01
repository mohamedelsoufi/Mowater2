<?php

namespace App\Repositories\TireExchangeCenter;

interface TireExchangeCenterInterface
{
    public function getAll();

    public function getCenterById($request);

    public function mawaterOffers($request);

    public function getServices();

    public function showService($request);
}
