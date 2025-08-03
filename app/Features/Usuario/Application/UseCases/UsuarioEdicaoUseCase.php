<?php
declare(strict_types=1);

namespace App\Features\Usuario\Application\UseCases;

use App\Features\Base\Application\Contracts\Transaction;
use App\Features\Usuario\Application\Contracts\UsuarioEdicaoUseCaseInterface;
use App\Features\Usuario\Application\Dto\UsuarioEdicaoDto;
use App\Features\Usuario\Application\Validators\PerfilValidators;
use App\Features\Usuario\Application\Validators\UsuarioValidators;
use App\Features\Usuario\Domain\Entities\Usuario;
use App\Features\Usuario\Domain\Repositories\PerfilRepository;
use App\Features\Usuario\Domain\Repositories\UsuarioRepository;
use App\Shared\Exceptions\NotFoundHttpException;
use Symfony\Component\CssSelector\Exception\InternalErrorException;

readonly class UsuarioEdicaoUseCase implements UsuarioEdicaoUseCaseInterface
{
    public function __construct(
        private UsuarioRepository $usuarioRepository,
        private PerfilRepository  $perfilRepository,

        private Transaction $transaction,
    )
    {
    }

    /**
     * @throws NotFoundHttpException
     * @throws InternalErrorException
     */
    public function execute(int $id, UsuarioEdicaoDto $usuarioEdicaoDto): Usuario
    {
        $usuario = UsuarioValidators::usuarioIdExiste($id, $this->usuarioRepository);
        $perfil = PerfilValidators::perfilIdExiste($usuarioEdicaoDto->perfilId, $this->perfilRepository);

        $usuario->setNome($usuarioEdicaoDto->nome);
        $usuario->setEmail($usuarioEdicaoDto->email);

        $this->transaction->beginTransaction();

        try {
            $usuarioAtualizado = $this->usuarioRepository->atualizar($usuario);

            $this->usuarioRepository->gerenciarPerfis($usuario->id, [$perfil->id]);

            return $usuarioAtualizado;
        } catch (\Exception $e) {
            $this->transaction->rollback();

            throw new InternalErrorException($e->getMessage());
        }
    }
}
