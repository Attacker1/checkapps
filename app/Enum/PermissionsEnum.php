<?php
namespace App\Enum;

class PermissionsEnum
{
    public const CAN_VERIVY_CHECKS = [
        'name' => 'Может проверять чеки',
        'slug' => 'can_verivy_checks',
    ];

    public const CAN_VIEW_ADMIN_PAGES = [
        'name' => 'Может заходить в админ панель',
        'slug' => 'can_view_admin_pages',
    ];

    public const CAN_VIEW_USERS = [
        'name' => 'Может просматривать пользователей',
        'slug' => 'can_view_users',
    ];

    public const CAN_BLOCK_USERS = [
        'name' => 'Может блокировать пользователей',
        'slug' => 'can_block_users',
    ];

    public const CAN_EDIT_SETTINGS = [
        'name' => 'Может измененять настройки',
        'slug' => 'can_edit_settings',
    ];

    public const CAN_BLOCK_ADMIN = [
        'name' => 'Может блокировать пользователей с админ правами',
        'slug' => 'can_block_admin',
    ];

    public static function values(): array
    {
        return [
            self::CAN_VERIVY_CHECKS,
            self::CAN_VIEW_ADMIN_PAGES,
            self::CAN_VIEW_USERS,
            self::CAN_BLOCK_USERS,
            self::CAN_EDIT_SETTINGS,
            self::CAN_BLOCK_ADMIN,
        ];
    }
}
