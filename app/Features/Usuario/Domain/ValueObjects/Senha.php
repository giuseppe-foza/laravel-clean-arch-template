<?php
declare(strict_types=1);

namespace App\Features\Usuario\Domain\ValueObjects;

use App\Shared\Utils\AppHash;
use DomainException;

final class Senha
{
    private string $senha;

    private function __construct(string $senha)
    {
        $this->senha = $senha;
    }

    public static function create(string $senha): self
    {
        return new self(AppHash::make($senha));
    }

    public static function check(string $senha, string $senhaCritografada): bool
    {
        return AppHash::check($senha, $senhaCritografada);
    }

    /**
     * @throws DomainException
     */
    public static function list(string $hash): self
    {
        return new self($hash);
    }

    public function toValue(): string
    {
        return $this->senha;
    }
}
