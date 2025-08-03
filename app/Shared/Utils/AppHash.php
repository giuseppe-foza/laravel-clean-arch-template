<?php
declare(strict_types=1);

namespace App\Shared\Utils;

use Illuminate\Support\Facades\Hash;

class AppHash
{
    public static function make(string $payload): string
    {
        return Hash::make($payload);
    }

    public static function check(string $payload, string $hashed): bool
    {
        return Hash::check($payload, $hashed);
    }
}
