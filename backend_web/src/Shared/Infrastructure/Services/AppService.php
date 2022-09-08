<?php
namespace App\Shared\Infrastructure\Services;

use App\Shared\Infrastructure\Traits\EnvTrait;
use App\Shared\Infrastructure\Traits\ErrorTrait;
use App\Shared\Infrastructure\Traits\LogTrait;
use TheFramework\Components\Session\ComponentEncdecrypt;
use App\Shared\Domain\Enums\ExceptionType;
use App\Shared\Infrastructure\Exceptions\BadRequestException;
use App\Shared\Infrastructure\Exceptions\ForbiddenException;
use App\Shared\Infrastructure\Exceptions\NotFoundException;
use \Exception;

/**
 * Class AppService
 * @package App\Services
 * No constructor,
 * ErrorTrait, LogTrait, EvnTrait, input,
 * _exception, _get_encdec
 */
abstract class AppService
{
    use ErrorTrait;
    use LogTrait;
    use EnvTrait;

    protected $input;

    /**
     * @param string $message
     * @param int $code
     * @throws BadRequestException
     * @throws ForbiddenException
     * @throws NotFoundException
     */
    protected function _exception(string $message, int $code=ExceptionType::CODE_INTERNAL_SERVER_ERROR): void
    {
        $this->logerr($message,"app-service.exception");
        switch ($code) {
            case ExceptionType::CODE_BAD_REQUEST: throw new BadRequestException($message);
            case ExceptionType::CODE_FORBIDDEN: throw new ForbiddenException($message);
            case ExceptionType::CODE_NOT_FOUND: throw new NotFoundException($message);
        }
        throw new Exception($message, $code);
    }

    protected function _get_encdec(): ComponentEncdecrypt
    {
        $encdec = new ComponentEncdecrypt(1);
        $encdec->set_sslmethod($this->get_env("SSLENC_METHOD"));
        $encdec->set_sslkey($this->get_env("SSLENC_KEY"));
        $encdec->set_sslsalt($this->get_env("SSLSALT"));
        return $encdec;
    }
}
