<?php
declare(strict_types=1);

namespace App\Features\Usuario\Domain\Props;

final class PerfilProps
{
    public function __construct(
        public string $nome,
        public string $chave,
        public bool $ativo,
        public string $dataCriacao,
    ) {}
}
