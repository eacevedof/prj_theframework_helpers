<?php

namespace App\Shared\Infrastructure\Factories;

use App\Shared\Infrastructure\Components\Datatable\DatatableComponent;

final class ComponentFactory
{
    public static function get(string $component): ?object
    {
        return new $component();
    }

    public static function get_datatable(array $input): ?DatatableComponent
    {
        return new DatatableComponent($input);
    }
}