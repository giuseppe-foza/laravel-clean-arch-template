<?php
declare(strict_types=1);

namespace App\Features\Usuario\Application\Contracts;

use App\Features\Usuario\Application\Dto\UsuarioEdicaoDto;
use App\Features\Usuario\Domain\Entities\Usuario;

interface UsuarioEdicaoUseCaseInterface
{
    public function execute(int $id, UsuarioEdicaoDto $usuarioEdicaoDto): Usuario;
}
