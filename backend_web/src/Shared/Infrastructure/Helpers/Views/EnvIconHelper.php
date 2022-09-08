<?php
namespace App\Shared\Infrastructure\Helpers\Views;

use \ENV;

final class EnvIconHelper
{
    private const ENV_LOGO = [
        ENV::LOCAL => "/themes/tema/images/tema-logo-local.svg",
        ENV::DEV => "/themes/tema/images/tema-logo-dev.svg",
        ENV::TEST => "/themes/tema/images/tema-logo-test.svg",
        ENV::PROD => "/themes/tema/images/tema-logo-orange.svg",
    ];

    private const ENV_LOGO_RESTRICT = [
        ENV::LOCAL => "/favicon/favicon-logo-local.svg",
        ENV::DEV => "/favicon/favicon-logo-dev.svg",
        ENV::TEST => "/favicon/favicon-logo-test.svg",
        ENV::PROD => "/favicon/favicon-logo-orange.svg",
    ];

    public static function icon(): string
    {
        $env = (string) ENV::env();
        return self::ENV_LOGO[$env] ?? "";
    }

    public static function icon_restrict(): string
    {
        $env = (string) ENV::env();
        return self::ENV_LOGO_RESTRICT[$env] ?? "";
    }
}
