<?php
declare(strict_types=1);

namespace App\Shared\Enums;

enum HttpRequestMethodsEnum
{
    const string GET = 'GET';
    const string POST = 'POST';
    const string PUT = 'PUT';
    const string PATCH = 'PATCH';
    const string DELETE = 'DELETE';
}
