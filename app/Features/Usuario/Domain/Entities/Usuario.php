<?php
declare(strict_types=1);

namespace App\Features\Usuario\Domain\Entities;

use App\Features\Base\Domain\Entities\BaseEntity;
use App\Features\Base\Domain\ValueObjects\Date;
use App\Features\Usuario\Domain\Props\UsuarioProps;
use App\Features\Usuario\Domain\ValueObjects\Senha;

final class Usuario extends BaseEntity
{
    private function __construct(private readonly UsuarioProps $props, ?int $entityId = null)
    {
        $this->props->dataCriacao = $this->props->dataCriacao ?: Date::create()->toValue();
        parent::__construct($entityId);
    }

    public string $nome {
        get => $this->props->nome;
    }

    public string $email {
        get => $this->props->email;
    }

    public bool $ativo {
        get => $this->props->ativo;
    }

    public ?bool $emailVerificado {
        get => $this->props->emailVerificado;
    }

    public ?string $dataCriacao {
        get => $this->props->dataCriacao;
    }

    public ?array $perfis {
        get => $this->props->perfis;
    }

    public function getSenha(): Senha {
        return $this->props->senha;
    }

    public function setNome(string $nome): void
    {
        $this->props->nome = $nome;
    }

    public function setEmail(string $email): void
    {
        $this->props->email = $email;
    }

    public function setSenha(Senha $senha): void
    {
        $this->props->senha = $senha;
    }

    public function setAtivo(bool $ativo): void
    {
        $this->props->ativo = $ativo;
    }

    public static function create(UsuarioProps $props): Usuario {
        return new self($props);
    }

    public static function reconstruct(UsuarioProps $props, int $entityId): Usuario {
        return new self($props, $entityId);
    }
}
