<?php

namespace App\Policies;

use App\Models\Company;
use App\Models\Enums\RoleEnum;
use App\Models\User;

class CompanyUserPolicy
{
    public function before(User $user): bool|null
    {
        if ($user->role_id === RoleEnum::ADMINISTRATOR) {
            return true;
        }

        return null;
    }

    public function viewAny(User $user, Company $company): bool
    {
        return $user->role_id === RoleEnum::COMPANY_OWNER && $user->company_id === $company->id;
    }

    public function create(User $user, Company $company): bool
    {
        return $user->role_id === RoleEnum::COMPANY_OWNER && $user->company_id === $company->id;
    }

    public function update(User $user, Company $company): bool
    {
        return $user->role_id === RoleEnum::COMPANY_OWNER && $user->company_id === $company->id;
    }

    public function delete(User $user, Company $company): bool
    {
        return $user->role_id === RoleEnum::COMPANY_OWNER && $user->company_id === $company->id;
    }
}
