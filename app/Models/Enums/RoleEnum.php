<?php

namespace App\Models\Enums;

enum RoleEnum: int
{
    case ADMINISTRATOR = 1;
    case COMPANY_OWNER = 2;
    case CUSTOMER = 3;
    case GUIDE = 4;

    public function isAdministrator(): bool
    {
        return $this == self::ADMINISTRATOR;
    }

    public function isCompanyOwner(): bool
    {
        return $this == self::COMPANY_OWNER;
    }

    public function isCustomer(): bool
    {
        return $this == self::CUSTOMER;
    }

    public function isGuide(): bool
    {
        return $this == self::GUIDE;
    }

    public function resolveDisplayableValue(): string
    {
        return match (true) {
            $this->isAdministrator() => 'Administratora',
            $this->isCompanyOwner() => 'Company Owner',
            $this->isCustomer() => 'Customer',
            $this->isGuide() => 'Guide',
        };
    }
}
