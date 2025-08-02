<?php

namespace App\Shared\Exceptions;

class ConflictHttpException extends AppException
{
    public function __construct(string $message = 'Conflito de dados.')
    {
        parent::__construct($message, 409, 'conflict');
    }
}
