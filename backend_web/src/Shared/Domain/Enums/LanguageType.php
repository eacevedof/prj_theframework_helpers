<?php

namespace App\Shared\Domain\Enums;

use JetBrains\PhpStorm\Pure;

abstract class LanguageType
{
    public const EN = "en";
    public const ES = "es";
    public const NL = "nl";
    public const PAP = "pap";

    public static function get_all(): array
    {
        return [
            self::EN,
            self::ES,
            self::NL,
            self::PAP,
        ];
    }

    #[Pure] public static function exists(string $lang): bool
    {
        $lang = strtolower($lang);
        return in_array($lang, self::get_all());
    }
}
