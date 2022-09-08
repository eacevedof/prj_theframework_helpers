<?php
namespace App\Shared\Infrastructure\Helpers;

use \BOOT;

final class RoutesHelper
{
    private const FIND_PARAMS_PATTERN = "/[\?|\?int|int]*:[a-z]+/";
    private const PATH_ROUTES = BOOT::PATH_SRC."/Shared/Infrastructure/routes/routes.php";
    private static ?array $routes = null;

    private static function _load_routes(): void
    {
        if (is_null(self::$routes))
            self::$routes = include(self::PATH_ROUTES);
    }

    private static function _get_params(string $url): array
    {
        $matches = [];
        preg_match_all(self::FIND_PARAMS_PATTERN, $url, $matches);
        return $matches[0] ?? [];
    }

    public static function url(string $name, array $args=[]): string
    {
        self::_load_routes();

        $route = array_filter(self::$routes, function (array $route) use ($name) {
            if (!$alias = ($route["name"] ?? "")) return false;
            return trim($alias) === $name;
        });
        if (!$route) return "";
        $route = array_values($route);
        $url = $route[0]["url"];
        if (!$args) return $url;

        $params = self::_get_params($url);
        $tags = array_keys($args);
        $tags = array_map(function (string $tagarg) use ($params) {
            $tag = str_starts_with($tagarg, ":") ? $tagarg : ":$tagarg";
            $param = array_filter($params, function (string $param) use($tag) {
                return strstr($param, $tag);
            });
            $param = array_values($param);
            return $param[0] ?? "";
        }, $tags);

        $values = array_values($args);
        $url = str_replace($tags, $values, $url);
        if (in_array("_nods", array_values($args))) {
            if (substr($url,-1) === "/")
                return substr_replace($url, "", -1);
        }
        return $url;
    }
}
