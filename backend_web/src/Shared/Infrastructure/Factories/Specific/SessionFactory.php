<?php

namespace App\Shared\Infrastructure\Factories\Specific;

use App\Shared\Infrastructure\Components\Session\SessionComponent;

final class SessionFactory
{
    public static function get(): SessionComponent
    {
        return new SessionComponent();
    }
}