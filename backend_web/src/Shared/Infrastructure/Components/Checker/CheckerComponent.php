<?php
namespace App\Shared\Infrastructure\Components\Checker;

final class CheckerComponent
{
    private const NAME_PATTERN = "/^([A-Z,a-zÑñáéíóú]+ )+[A-Z,a-zÑñáéíóú]+$|^[A-Z,a-záéíóú]+$/";
    private const ADDRESS_PATTERN = "/^[a-zA-ZÑñáéíóú]+[a-zA-ZÑñáéíóú0-9\s,\.'\-]{3,}[a-zA-Z0-9\.]$/";
    private const PHONE_PATTERN = "/^(\d{3} )+\d+$|^\d{3,}$/";

    public static function is_valid_url(?string $value): bool
    {
        if (!$value) return false;
        $proto = substr($value, 0, 8);
        if (!(strstr($proto, "http://") || strstr($proto, "https://")))
            return false;

        return filter_var($value, FILTER_VALIDATE_URL);
    }

    public static function is_valid_color(?string $hexcolor): bool
    {
        if (!$hexcolor) return false;
        $hexcolor = ltrim($hexcolor, "#");
        if (
            ctype_xdigit($hexcolor) &&
            (strlen($hexcolor) == 6 || strlen($hexcolor) == 3)
        )
            return true;
        return false;
    }

    public static function is_valid_email(?string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public static function name_format(?string $name): bool
    {
        $matches = [];
        preg_match(self::NAME_PATTERN, $name, $matches);
        return (bool) ($matches[0] ?? "");
    }

    public static function address_format(?string $address): bool
    {
        $matches = [];
        preg_match(self::ADDRESS_PATTERN, $address, $matches);
        return (bool) ($matches[0] ?? "");
    }

    public static function is_boolean(?string $value): bool
    {
        return in_array($value, ["", "1", "0", 0, 1,null]);
    }

    public static function phone_format(?string $phone): bool
    {
        $matches = [];
        preg_match(self::PHONE_PATTERN, $phone, $matches);
        return (bool) ($matches[0] ?? "");
    }

    public static function is_valid_date(?string $date): bool
    {
        if (!$date) return false;
        if (strlen($date)!=10) return false;
        $date = explode("-",$date);
        return checkdate(
            (int)($date[1] ?? ""),
            (int)($date[2] ?? ""),
            (int)$date[0]
        );
    }

}