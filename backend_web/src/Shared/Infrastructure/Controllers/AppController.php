<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link eduardoaf.com
 * @name App\Controllers\AppController 
 * @file AppController.php v1.2.0
 * @date 01-07-2021 20:14 SPAIN
 * @observations
 */
namespace App\Shared\Infrastructure\Controllers;

use App\Shared\Infrastructure\Traits\LogTrait;
use App\Shared\Infrastructure\Traits\EnvTrait;
use App\Shared\Infrastructure\Traits\ErrorTrait;

abstract class AppController
{
    use ErrorTrait;
    use LogTrait;
    use EnvTrait;

    protected function _request_log(): void
    {
        $sReqUri = $_SERVER["REQUEST_URI"];
        $this->logreq("appcontroller._request_log");
        $this->logreq($_SERVER["HTTP_USER_AGENT"] ?? "","HTTP_USER_AGENT");
        $this->logreq($_SERVER["REMOTE_ADDR"] ?? "","REMOTE_ADDR");
        $this->logreq($_SERVER["REMOTE_HOST"] ?? "","REMOTE_HOST");
        $this->logreq($_SERVER["HTTP_HOST"] ?? "","HTTP_HOST");
        //$this->logd($_SERVER["REMOTE_USER"] ?? "","REMOTE_USER");

        $this->logreq($_FILES,"$sReqUri FILES");
        $this->logreq($_SESSION, "$sReqUri SESSION");
        $this->logreq($_GET,"$sReqUri GET");
        $this->logreq($_POST,"$sReqUri POST");
    }

}//AppController
