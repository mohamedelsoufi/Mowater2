<?php

namespace App\Repositories\TechnicalInspectionCenter;

interface TechnicalInspectionCenterInterface
{
    public function getAll();

    public function getCenterById($request);

    public function mawaterOffers($request);

    public function offers($request);

    public function getServices();

    public function showService($request);

    public function ServiceAvailableTimes($request);

    public function requestTechnicalInspection($request);

    public function getUserRequests();

    public function ShowUserRequest($request);
}
