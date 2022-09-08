<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link eduardoaf.com
 * @name App\Factories\ServiceFactory
 * @file EncryptFactory.php v1.0.0
 * @date 25-06-2021 19:50 SPAIN
 * @observations
 */
namespace App\Shared\Infrastructure\Factories;

use App\Shared\Infrastructure\Services\AppService;
use App\Restrict\Auth\Application\AuthService;

final class ServiceFactory
{
    public static function get_auth(): AuthService
    {
        return AuthService::getme();
    }

    public static function get(string $service, array $params = []): ?AppService
    {
        return new $service($params);
    }

    public static function get_callable(string $service, array $params = []): callable
    {
        $callable = new $service($params);
        return $callable;
    }
}//ServiceFactory
