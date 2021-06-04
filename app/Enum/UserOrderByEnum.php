<?php
namespace App\Enum;

class UserOrderByEnum
{
    public const DESC = 'DESC';
    public const ASC = 'ASC';

    public static function values(): array
    {
        return [self::DESC, self::ASC];
    }
}
