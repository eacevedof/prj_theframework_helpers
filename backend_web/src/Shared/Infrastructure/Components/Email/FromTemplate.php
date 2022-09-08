<?php
namespace App\Shared\Infrastructure\Components\Email;

final class FromTemplate
{
    public static function get_content(string $filename, array $vars): string
    {
        ob_start();
        foreach ($vars as $name=>$value)
            $$name = $value;
        include $filename;
        return ob_get_clean();
    }
}