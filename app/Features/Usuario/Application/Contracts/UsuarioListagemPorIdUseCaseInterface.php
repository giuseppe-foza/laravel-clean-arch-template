<?php
declare(strict_types=1);

namespace App\Features\Usuario\Application\Contracts;

use App\Features\Usuario\Domain\Entities\Usuario;

interface UsuarioListagemPorIdUseCaseInterface
{
    public function execute(int $id): Usuario;
}
