<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link eduardoaf.com
 * @name App\Traits\ErrorTrait
 * @file ErrorTrait.php 1.0.0
 * @date 01-11-2018 19:00 SPAIN
 * @observations
 */
namespace App\Shared\Infrastructure\Traits;

trait ErrorTrait
{
    protected array $errors = [];
    protected bool $iserror = false;
        
    protected function add_error($sMessage){$this->iserror = true;$this->errors[]=$sMessage;}
    protected function _set_errors(array $errors){$this->iserror = true; $this->errors=$errors;}

    private function _get_flattened(array $array): array
    {
        //de un array asociativo devuelve un array simple
        $flatten = [];
        array_walk_recursive($array, function ($a) use (&$flatten) {
            $flatten[] = $a;
        });
        return $flatten;
    }

    public function is_error():bool{return $this->iserror;}

    public function get_errors(bool $flattern=false): array
    {
        if(!$flattern) return $this->errors;
        return $this->_get_flattened($this->errors);
    }

    public function get_error($i=0){return $this->errors[$i] ?? null;}

}//ErrorTrait
