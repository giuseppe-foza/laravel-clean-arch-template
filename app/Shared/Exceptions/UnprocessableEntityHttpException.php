<?php

namespace App\Shared\Exceptions;

class UnprocessableEntityHttpException extends AppException
{
    public function __construct(string $message = 'Entidade não processável.')
    {
        parent::__construct($message, 422, 'unprocessable_entity');
    }
}
