<?php

namespace App\Enum;

final readonly class LocaleEnum
{
    // routes
    public const string ca = 'ca';
    public const string es = 'es';
    public const string en = 'en';

    public static function getLocalesArray(): array
    {
        return [
            self::ca,
            self::es,
            self::en,
        ];
    }
}
