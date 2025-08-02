<?php

namespace App\Shared\Exceptions;

class NotFoundHttpException extends AppException
{
    public function __construct(string $message = 'Recurso não encontrado.')
    {
        parent::__construct($message, 404, 'not_found');
    }
}
