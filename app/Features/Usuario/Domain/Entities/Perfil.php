<?php
declare(strict_types=1);

namespace App\Features\Usuario\Domain\Entities;

use App\Features\Base\Domain\Entities\BaseEntity;
use App\Features\Base\Domain\ValueObjects\Date;
use App\Features\Usuario\Domain\Props\PerfilProps;

final class Perfil extends BaseEntity
{
    private function __construct(private readonly PerfilProps $props, ?int $entityId = null)
    {
        $this->props->dataCriacao = $this->props->dataCriacao ?: Date::create()->toValue();
        parent::__construct($entityId);
    }

    public string $nome {
        get => $this->props->nome;
    }

    public string $chave {
        get => $this->props->chave;
    }

    public bool $ativo {
        get => $this->props->ativo;
    }

    public string $dataCriacao {
        get => $this->props->dataCriacao;
    }

    public static function create(PerfilProps $props): Perfil {
        return new self($props);
    }

    public static function reconstruct(PerfilProps $props, int $entityId): Perfil {
        return new self($props, $entityId);
    }
}
