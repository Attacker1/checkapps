<?php
namespace App\Enum;

class RolesEnum
{
    public const USER = [
        'role_data' => [
            'name' => 'Пользователь',
            'slug' => 'user',
        ],
        'permissions' => [
            PermissionsEnum::VERIFY_CHECKS,
        ],
    ];

    public const ADMIN = [
        'role_data' => [
            'name' => 'Администратор',
            'slug' => 'admin',
        ],
        'permissions' => [
            PermissionsEnum::VERIFY_CHECKS,
            PermissionsEnum::BLOCK_USERS,
        ],
    ];

    public const SUPER_ADMIN = [
        'role_data' => [
            'name' => 'Главный администратор',
            'slug' => 'super-admin',
        ],
        'permissions' => [
            PermissionsEnum::VERIFY_CHECKS,
            PermissionsEnum::BLOCK_USERS,
            PermissionsEnum::EDIT_SETTINGS,
        ],
    ];

    public static function values(): array
    {
        return [
            self::USER,
            self::ADMIN,
            self::SUPER_ADMIN,
        ];
    }
}
