<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link eduardoaf.com
 * @name App\Traits\SessionTrait
 * @file SessionTrait.php 1.0.0
 * @date 21-07-2020 19:00 SPAIN
 * @observations
 */
namespace App\Shared\Infrastructure\Traits;

use TheFramework\Components\Session\ComponentCookie;

/**
 * Trait CookieTrait
 * @package App\Traits
 * this->cookie, _cookieinit()
 */
trait CookieTrait
{
    private ?ComponentCookie $cookie = null;

    protected function _load_cookie(): ComponentCookie
    {
        if(!$this->cookie) $this->cookie = new ComponentCookie();
        return $this->cookie;
    }

}//CookieTrait
