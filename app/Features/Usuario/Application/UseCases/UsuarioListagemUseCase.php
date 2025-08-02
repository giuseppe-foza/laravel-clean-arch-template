<?php
declare(strict_types=1);

namespace App\Features\Usuario\Application\UseCases;

use App\Features\Usuario\Application\Contracts\UsuarioListagemUseCaseInterface;
use App\Features\Usuario\Domain\Repositories\UsuarioRepository;

final readonly class UsuarioListagemUseCase implements UsuarioListagemUseCaseInterface
{
    public function __construct(private UsuarioRepository $usuarioRepository)
    {
    }

    public function execute(): array
    {
        return $this->usuarioRepository->listarTodos();
    }
}
