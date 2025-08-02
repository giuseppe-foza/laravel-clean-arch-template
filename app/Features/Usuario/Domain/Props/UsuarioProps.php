<?php
declare(strict_types=1);

namespace App\Features\Usuario\Domain\Props;

use App\Features\Usuario\Domain\Entities\Perfil;

/**
 * @param Perfil[]|null $perfis
 */
final class UsuarioProps
{
    public function __construct(
        public string $nome,
        public string $email,
        public string $senha,
        public bool $ativo,
        public ?bool $emailVerificado,
        public string $dataCriacao,
        public ?array $perfis,
    ) {}
}
