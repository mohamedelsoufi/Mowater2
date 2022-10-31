<?php


namespace App\Traits\Branches;

trait HasBranches
{
    public function branches()
    {
        return $this->morphMany('App\Models\Branch', 'branchable');
    }
}
