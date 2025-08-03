<?php
declare(strict_types=1);

namespace App\Features\Usuario\Application\Contracts;

use App\Features\Usuario\Application\Dto\UsuarioInsercaoDto;
use App\Features\Usuario\Domain\Entities\Usuario;

interface UsuarioInsercaoUseCaseInterface
{
    public function execute(UsuarioInsercaoDto $usuarioInsercaoDto): Usuario;
}
