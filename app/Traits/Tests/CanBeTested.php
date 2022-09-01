<?php


namespace App\Traits\Tests;

use App\Models\TestDrive;

trait CanBeTested
{
    public function tests()
    {
        return $this->morphMany(TestDrive::class, 'testable');
    }
}
