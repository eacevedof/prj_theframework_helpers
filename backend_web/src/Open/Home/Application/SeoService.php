<?php
namespace App\Open\Home\Application;

use App\Shared\Infrastructure\Helpers\RoutesHelper as Routes;

final class SeoService
{
    private const EMPTY = [
        "title" => "",
        "description" => "",
        "keywords" => "",
        "h1" => ""
    ];

    private static $seo = [
        "home.we" => [
            "title" => "Nosotros - El Chalán",
            "description" => "Breve historia, visión y misión de El Chalán",
            "keywords" => "historia, visión, misión, comida peruana, aruba, oranjestad",
            "h1" => "Nosotros - El Chalán",
        ],
        "home.themenu" => [
            "title" => "La Carta - El Chalán",
            "description" => "Algunos platos y postres que se puede disfrutar en El Chalán",
            "keywords" => "carta, platos, variedad, pescados, mariscos, carnes, arroz",
            "h1" => "La Carta - El Chalán",
        ],
        "home.events" => [
            "title" => "Eventos - El Chalán",
            "description" => "Tipos de eventos que puedes celebrar o contratar en nuestro local",
            "keywords" => "Coorportaivos, sociales, Benéficos, Cumpleaños Fiestas Infantiles",
            "h1" => "Eventos - El Chalán",
        ],
        "home.contact" => [
            "title" => "Contacto - El Chalán",
            "description" => "Localización y formulario de contacto",
            "keywords" => "contacto, formulario, mapa, teléfono, dirección",
            "h1" => "Contacto - El Chalán",
        ],
        "home.index" => [
            "title" => "El Chalán - Podrás disfrutar de la mejor gastronomía peruana",
            "description" => "Restaurante de comida peruana en Aruba - Oranjestad",
            "keywords" => "restaurante, restaurant, comida, perú, peru, aruba",
            "h1" => "El Chalán - Podrás disfrutar de la mejor gastronomía peruana",
        ],
    ];

    public static function get_meta(string $routename): array
    {
        $seo = self::$seo[$routename] ?? self::EMPTY;
        $seo["canonical"] = SeoService::get_canonical($routename);
        $seo["route"] = Routes::url($routename);
        return $seo;
    }

    public static function get_canonical(string $routename): string
    {
        $found = ($found = Routes::url($routename)) === "/" ? "" : $found;
        return "http://".getenv("APP_DOMAIN").$found;
    }

}