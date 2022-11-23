<?php

declare(strict_types=1);

namespace app\shared\exception;

use RuntimeException;
use Throwable;

final class NotFoundException extends RuntimeException
{
    public function __construct(string $message = 'Not found.', int $code = 404, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}