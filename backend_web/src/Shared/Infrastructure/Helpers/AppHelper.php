<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link eduardoaf.com
 * @name App\Shared\Infrastructure\Helpers\AppHelper
 * @file AppHelper.php 1.0.0
 * @date 29-11-2018 19:00 SPAIN
 * @observations
 * @tags: #apify
 */
namespace App\Shared\Infrastructure\Helpers;

use App\Shared\Infrastructure\Traits\ErrorTrait;
use App\Shared\Infrastructure\Traits\LogTrait;
use App\Shared\Infrastructure\Traits\EnvTrait;
use \Exception;

abstract class AppHelper
{
    use ErrorTrait;
    use LogTrait;
    use EnvTrait;

}//AppHelper
