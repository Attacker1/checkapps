<?php


namespace App\Enum;


class CheckStatusEnum
{
    public const INCHECK = 'INCHECK';
    public const APPROVE = 'APPROVE';
    public const REJECT = 'REJECT';

    public static function statuses(): array
    {
        return [self::INCHECK, self::APPROVE, self::REJECT];
    }
}
