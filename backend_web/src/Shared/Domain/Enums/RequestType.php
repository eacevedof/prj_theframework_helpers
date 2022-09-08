<?php

namespace App\Shared\Domain\Enums;

abstract class RequestType
{
    public const LANG = "lang";
    public const CSRF = "_csrf";
    public const ACTION = "_action";
    public const APP_TRANSLATIONS = "APP_TRANSLATIONS";
    public const APP_ACTION = "APP_ACTION";
}
