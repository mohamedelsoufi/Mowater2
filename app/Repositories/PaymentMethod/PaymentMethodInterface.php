<?php

namespace App\Repositories\PaymentMethod;

interface PaymentMethodInterface
{
    public function getAll();

    public function getById($request);
}
