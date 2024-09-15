<?php

namespace App\Enums;

use App\Models\Roles as RoleModel;


enum Roles: string
{
    case ADMIN = 'admin';
    case USER  = 'user';


    public function title(): string
    {
        return ucfirst($this->value);
    }

    /**
     * Search for a role by its value.
     *
     * @param string $value The value to search for
     * @return ?Roles The role if found, null otherwise
     */
    public static function searchByValue(string $value): ?Roles
    {
        $lowercaseValue = strtolower($value);
        foreach (self::cases() as $case) {
            if (strtolower($case->value) === $lowercaseValue) {
                return $case;
            }
        }
        return null;
    }

    public static function getRoleIdByValue(string $value)
    {
        $role = Roles::searchByValue($value);
        if ($role !== null) {
            $foundRole = RoleModel::where('name', $role->title())->first();
            if ($foundRole !== null) {
                return $foundRole->id;
            }
        }
        return null;
    }
}
