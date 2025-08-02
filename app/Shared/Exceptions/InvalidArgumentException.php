<?php
declare(strict_types=1);

namespace App\Shared\Exceptions;

class InvalidArgumentException extends AppException
{
    public function __construct(string|array $message = 'Argumento inválido.')
    {
        parent::__construct($message, 400, 'invalid_argument');
    }
}
