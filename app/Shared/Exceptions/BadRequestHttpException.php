<?php

namespace App\Shared\Exceptions;

class BadRequestHttpException extends AppException
{
    public function __construct(string $message = 'Requisição inválida.')
    {
        parent::__construct($message, 400, 'bad_request');
    }
}
