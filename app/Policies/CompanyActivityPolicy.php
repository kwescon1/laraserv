<?php

namespace App\Policies;

use App\Models\Activity;
use App\Models\Company;
use App\Models\Enums\RoleEnum;
use App\Models\User;

class CompanyActivityPolicy
{
    public function before(User $user): bool|null
    {
        if ($user->role_id === RoleEnum::ADMINISTRATOR) {
            return true;
        }

        return null;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user, Company $company): bool
    {
        return $user->role_id === RoleEnum::COMPANY_OWNER && $user->company_id === $company->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Company $company): bool
    {
        return $user->role_id === RoleEnum::COMPANY_OWNER && $user->company_id === $company->id;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Activity $activity): bool
    {
        return $user->role_id === RoleEnum::COMPANY_OWNER && $user->company_id === $activity->company_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Activity $activity): bool
    {
        return $user->role_id === RoleEnum::COMPANY_OWNER && $user->company_id === $activity->company_id;
    }
}
