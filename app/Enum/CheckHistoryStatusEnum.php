<?php


namespace App\Enum;


class CheckHistoryStatusEnum
{
    public const APPROVED = 'APPROVED';
    public const REJECTED = 'REJECTED';

    public static function statuses(): array
    {
        return [self::APPROVED, self::REJECTED];
    }
}
