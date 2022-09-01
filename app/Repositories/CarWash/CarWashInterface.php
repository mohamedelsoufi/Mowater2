<?php

namespace App\Repositories\CarWash;

interface CarWashInterface
{
    public function getAll();

    public function getCarWashById($request);

    public function mawaterOffers($request);

    public function getServices();

    public function showService($request);

    public function ServiceAvailableTimes($request);

    public function requestCarWash($request);

    public function getUserRequests();

    public function ShowUserRequest($request);
}
