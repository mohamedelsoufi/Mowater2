<?php

namespace App\Traits\OrganizationUsers;

use App\Models\OrganizationUser;

trait HasOrgUsers
{
    public function organization_users()
    {
        return $this->morphMany(OrganizationUser::class, 'organizable');
    }
}
