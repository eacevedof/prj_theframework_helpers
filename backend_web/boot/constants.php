<?php
//constants.php 20200721
define("PATH_ROOT", dirname(__DIR__));

abstract class ENV
{
    public const LOCAL = "local";
    public const DEV = "dev";
    public const TEST = "test";
    public const PROD = "prod";

    public const COLORS = [
        self::LOCAL => "#fc0ac3", //rosa
        self::DEV => "#0174ee", //azul
        self::TEST => "#2f8a01", //verde
        self::PROD => "",
    ];

    public static function is_local(): bool { return self::LOCAL === getenv("APP_ENV");}
    public static function is_dev(): bool { return self::DEV === getenv("APP_ENV");}
    public static function is_test(): bool { return self::TEST === getenv("APP_ENV");}
    public static function is_prod(): bool { return self::PROD === getenv("APP_ENV");}

    public static function env(): string { return getenv("APP_ENV");}

    public static function is_debug(): bool { return (bool) getenv("APP_DEBUG"); }

    public static function color(): string
    {
        switch (getenv("APP_ENV")) {
            case self::LOCAL:
                return self::COLORS[self::LOCAL];
            case self::DEV:
                return self::COLORS[self::DEV];
            case self::TEST:
                return self::COLORS[self::TEST];
        }
        return "";
    }
}

abstract class BOOT
{
    public const PATH_ROOT = PATH_ROOT;
    public const PATH_PUBLIC = PATH_ROOT."/public";
    public const PATH_VENDOR = PATH_ROOT."/vendor";
    public const PATH_SRC = PATH_ROOT."/src";
    public const PATH_DISK_CACHE = PATH_ROOT."/cache";
    public const PATH_SRC_CONFIG = PATH_ROOT."/config";
    public const PATH_LOGS = PATH_ROOT."/logs";
    public const PATH_CONSOLE = PATH_ROOT."/console";
}
