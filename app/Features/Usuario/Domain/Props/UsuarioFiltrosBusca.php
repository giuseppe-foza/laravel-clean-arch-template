<?php
declare(strict_types=1);

namespace App\Features\Usuario\Domain\Props;

final readonly class UsuarioFiltrosBusca
{
    private ?string $nome;
    private ?string $email;

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(?string $nome = null): void
    {
        $this->nome = $nome;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email = null): void
    {
        $this->email = $email;
    }
}
