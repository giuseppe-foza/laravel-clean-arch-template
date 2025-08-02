<?php

namespace App\Shared\Exceptions;

class UnauthorizedHttpException extends AppException
{
    public function __construct(string $message = 'Não autorizado.')
    {
        parent::__construct($message, 401, 'unauthorized');
    }
}
