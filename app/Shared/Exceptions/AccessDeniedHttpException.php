<?php

namespace App\Shared\Exceptions;

use App\Shared\Enums\MessagesEnum;

class AccessDeniedHttpException extends AppException
{
    public function __construct(string $message = 'Acesso negado.')
    {
        parent::__construct($message, 403, 'access_denied');
    }
}
