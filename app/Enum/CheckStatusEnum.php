<?php


namespace App\Enum;


class CheckStatusEnum
{
    public const INCHECK = 'INCHECK';
    public const APPROVE = 'REJECT';
    public const REJECT = 'APPROVE';

    public static function statuses(): array
    {
        return [self::INCHECK, self::APPROVE, self::REJECT];
    }
}
