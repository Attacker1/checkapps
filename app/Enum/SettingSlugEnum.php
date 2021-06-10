<?php


namespace App\Enum;


class SettingSlugEnum
{
    public const CHECK_VERIFY_QUANTITY = [
        'slug' => 'check_verify_quantity',
        'name' => 'Количество проверок чека',
        'value' => 5,
    ];
    public const CHECK_VERIFY_PRICE = [
        'slug' => 'check_verify_price',
        'name' => 'Вознаграждение за проверку',
        'value' => 5,
    ];
    public const CHECK_EXPIRITY_TIME = [
        'slug' => 'check_expirity_time',
        'name' => 'Срок жизни чека',
        'value' => 72,
    ];
    public const CHECK_MINIMAL_LIMIT = [
        'slug' => 'check_minimal_limit',
        'name' => 'Лимит при которм запрашивать новые чеки',
        'value' => 1000,
    ];

    public const CHECK_GET_QUANTITY = [
        'slug' => 'check_get_quantity',
        'name' => 'Сколько чеков загружать по достижении лимита',
        'value' => 5000,
    ];

    public static function values(): array
    {
        return [
            self::CHECK_VERIFY_QUANTITY,
            self::CHECK_VERIFY_PRICE,
            self::CHECK_EXPIRITY_TIME,
            self::CHECK_MINIMAL_LIMIT,
            self::CHECK_GET_QUANTITY,
        ];
    }
}
