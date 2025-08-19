<?php

namespace App\Enum;

final readonly class LocaleEnum
{
    // routes
    public const string en = 'en';
    public const string es = 'es';
    public const string ca = 'ca';

    public static function getLocalesArray(): array
    {
        return [
            self::en,
            self::es,
            self::ca,
        ];
    }
}
