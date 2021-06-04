<?php
namespace App\Enum;

class PermissionsEnum
{
    public const VERIFY_CHECKS = [
        'name' => 'Проверка чеков',
        'slug' => 'verify_check',
    ];

    public const BLOCK_USERS = [
        'name' => 'Блокировать пользователей',
        'slug' => 'block_users',
    ];

    public const EDIT_SETTINGS = [
        'name' => 'Изменение настроек',
        'slug' => 'edit_settings',
    ];

    public static function values(): array
    {
        return [
            self::VERIFY_CHECKS,
            self::BLOCK_USERS,
            self::EDIT_SETTINGS,
        ];
    }
}
