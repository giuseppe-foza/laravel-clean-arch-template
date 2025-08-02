<?php

namespace App\Shared\Exceptions;

class TooManyRequestsHttpException extends AppException
{
    public function __construct(string $message = 'Muitas requisições. Tente novamente mais tarde.')
    {
        parent::__construct($message, 429, 'too_many_requests');
    }
}
