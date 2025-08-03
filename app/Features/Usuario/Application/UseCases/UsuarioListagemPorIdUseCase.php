<?php
declare(strict_types=1);

namespace App\Features\Usuario\Application\UseCases;

use App\Features\Usuario\Application\Contracts\UsuarioListagemPorIdUseCaseInterface;
use App\Features\Usuario\Application\Validators\UsuarioValidators;
use App\Features\Usuario\Domain\Entities\Usuario;
use App\Features\Usuario\Domain\Repositories\UsuarioRepository;
use App\Shared\Exceptions\NotFoundHttpException;

final readonly class UsuarioListagemPorIdUseCase implements UsuarioListagemPorIdUseCaseInterface
{
    public function __construct(private UsuarioRepository $usuarioRepository)
    {
    }

    /**
     * @throws NotFoundHttpException
     */
    public function execute(int $id): Usuario
    {
        return UsuarioValidators::usuarioIdExiste($id, $this->usuarioRepository);
    }
}
