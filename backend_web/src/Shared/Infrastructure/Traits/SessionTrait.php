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

use App\Shared\Infrastructure\Components\Session\SessionComponent;
use App\Shared\Infrastructure\Factories\Specific\SessionFactory as SsF;

/**
 * Trait SessionTrait
 * @package App\Traits
 * this->session, _load_session()
 */
trait SessionTrait
{
    protected ?SessionComponent $session = null;

    protected function _load_session(): SessionComponent
    {
        if(!$this->session) $this->session = SsF::get();
        return $this->session;
    }

}//SessionTrait
