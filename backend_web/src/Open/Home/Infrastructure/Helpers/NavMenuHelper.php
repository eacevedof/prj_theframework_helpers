<?php
namespace App\Open\Home\Infrastructure\Helpers;

use App\Shared\Infrastructure\Helpers\RoutesHelper as Routes;
use App\Shared\Infrastructure\Traits\RequestTrait;

final class NavMenuHelper
{
    use RequestTrait;

    public static function get_self(): self
    {
        return new self();
    }

    public function get_selected(): array
    {
        $requri = $this->_load_request()->get_request_uri();
        $selected = "current-menu-item";
        $navmenu = [
            "nosotros" => Routes::url("home.versions"),
            "inicio" => Routes::url("home.index"),
        ];

        $found = false;
        foreach($navmenu as $name => $path) {
            if (strstr($requri, $path) && !$found) {
                $navmenu[$name] = $selected;
                $found = true;
            }
            else {
                unset($navmenu[$name]);
            }
        }
        return $navmenu;
    }
}
