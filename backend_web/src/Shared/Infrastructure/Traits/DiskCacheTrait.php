<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link eduardoaf.com
 * @name App\Traits\DiskCacheTrait
 * @file DiskCacheTrait.php 1.0.0
 * @date 21-07-2020 19:00 SPAIN
 * @observations
 */
namespace App\Shared\Infrastructure\Traits;

use App\Shared\Infrastructure\Factories\ComponentFactory;
use App\Shared\Infrastructure\Components\DiskCache\DiskCacheComponent;

trait DiskCacheTrait
{
    protected ?DiskCacheComponent $diskcache = null;

    protected function _load_diskcache()
    {
        $this->diskcache = ComponentFactory::get(DiskCacheComponent::class);
    }

}//DiskCacheTrait
