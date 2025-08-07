<?php
declare(strict_types=1);

namespace App\Shared\Utils;

use RuntimeException;

final class AppHash
{
    private const int COST = 12;

    /**
     * Gera um hash bcrypt com 12 rounds
     */
    public static function make(string $payload): string
    {
        $hash = password_hash($payload, PASSWORD_BCRYPT, [
            'cost' => self::COST,
        ]);

        if (!is_string($hash)) {
            throw new RuntimeException('Erro ao gerar o hash da senha.');
        }

        return $hash;
    }

    public static function check(string $payload, string $hashed): bool
    {
        return password_verify($payload, $hashed);
    }
}
