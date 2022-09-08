<?php

namespace App\Shared\Infrastructure\Exceptions;
use \Exception;
use App\Shared\Domain\Enums\ExceptionType;

final class NotFoundException extends Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message, ExceptionType::CODE_NOT_FOUND);
    }
}