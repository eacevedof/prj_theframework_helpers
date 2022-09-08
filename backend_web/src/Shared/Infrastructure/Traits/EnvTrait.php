<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link eduardoaf.com
 * @name App\Traits\EnvTrait
 * @file EnvTrait.php 1.0.0
 * @date 21-07-2020 19:00 SPAIN
 * @observations
 */
namespace App\Shared\Infrastructure\Traits;

trait EnvTrait
{
    protected function get_env($key=null){ return ($key===null)?$_ENV:$_ENV[$key] ?? "";}

    protected function get_appenv($key){return $this->get_env("APP_{$key}");}

    protected function is_envprod(){return $this->get_appenv("ENV")==="prod";}

    protected function is_envtest(){return $this->get_appenv("ENV")==="test";}

    protected function is_envdev(){return $this->get_appenv("ENV")==="dev";}

    protected function is_envlocal(){return $this->get_appenv("ENV")==="local";}

    protected function add_env(string $key, $mxvalue){$_ENV[$key] = $mxvalue;}

}//EnvTrait
