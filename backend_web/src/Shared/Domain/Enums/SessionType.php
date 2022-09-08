<?php

namespace App\Shared\Domain\Enums;

abstract class SessionType
{
    const AUTH_USER_LANG = "lang";
    const AUTH_USER_TZ = "tz";
    const AUTH_USER_ID_TZ = "id_tz";

    const AUTH_USER = "auth_user";
    const AUTH_USER_PERMISSIONS = "auth_user_permissions";
}
