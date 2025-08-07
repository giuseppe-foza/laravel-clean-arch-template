<?php
declare(strict_types=1);

namespace App\Features\Usuario\Application\UseCases;

use App\Features\Base\Domain\Entities\Paginator;
use App\Features\Usuario\Application\Contracts\UsuarioListagemUseCaseInterface;
use App\Features\Usuario\Application\Dto\UsuarioFiltrosBuscaDto;
use App\Features\Usuario\Domain\Repositories\UsuarioRepository;

final readonly class UsuarioListagemUseCase implements UsuarioListagemUseCaseInterface
{
    public function __construct(private UsuarioRepository $usuarioRepository)
    {
    }

    public function execute(UsuarioFiltrosBuscaDto $usuarioFiltrosBuscaDto): Paginator
    {
        return $this->usuarioRepository->listarTodos(
            $usuarioFiltrosBuscaDto->usuarioFiltrosBusca,
            $usuarioFiltrosBuscaDto->paginacaoOrdenacao
        );
    }
}
