<?php
namespace App\Enum;

class UserSearchByEnum
{
    public const EMAIL = 'user_email';
    public const FIO = 'user_fio';

    public static function values(): array
    {
        return [self::EMAIL, self::FIO];
    }
}
