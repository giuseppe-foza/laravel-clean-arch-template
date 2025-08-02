<?php
declare(strict_types=1);

namespace App\Features\Usuario\Application\Contracts;

interface UsuarioListagemUseCaseInterface
{
    public function execute(): array;
}
