<?php
declare(strict_types=1);

namespace App\Features\Usuario\Application\Contracts;

use App\Features\Base\Domain\Entities\Paginator;
use App\Features\Usuario\Application\Dto\UsuarioFiltrosBuscaDto;

interface UsuarioListagemUseCaseInterface
{
    public function execute(UsuarioFiltrosBuscaDto $usuarioFiltrosBuscaDto): Paginator;
}
