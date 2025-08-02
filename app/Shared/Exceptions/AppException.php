<?php
declare(strict_types=1);

namespace App\Shared\Exceptions;

use Exception;

class AppException extends Exception
{
    public function __construct(
        string|array $message,
        int $code = 0,
        public readonly ?string $slug = null,
    )
    {
        parent::__construct(
            is_array($message) ? json_encode($message) : $message,
            $code
        );
    }
}

