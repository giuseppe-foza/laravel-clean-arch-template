<?php
declare(strict_types=1);

namespace App\Features\Usuario\Application\UseCases;

use App\Features\Base\Application\Contracts\Transaction;
use App\Features\Usuario\Application\Contracts\UsuarioInsercaoUseCaseInterface;
use App\Features\Usuario\Application\Dto\UsuarioInsercaoDto;
use App\Features\Usuario\Application\Validators\PerfilValidators;
use App\Features\Usuario\Application\Validators\UsuarioValidators;
use App\Features\Usuario\Domain\Entities\Usuario;
use App\Features\Usuario\Domain\Props\UsuarioProps;
use App\Features\Usuario\Domain\Repositories\PerfilRepository;
use App\Features\Usuario\Domain\Repositories\UsuarioRepository;
use App\Features\Usuario\Domain\ValueObjects\Senha;
use App\Shared\Exceptions\ConflictHttpException;
use App\Shared\Exceptions\NotFoundHttpException;
use App\Shared\Utils\AppHash;
use Symfony\Component\CssSelector\Exception\InternalErrorException;

final readonly class UsuarioInsercaoUseCase implements UsuarioInsercaoUseCaseInterface
{
    public function __construct(
        private UsuarioRepository $usuarioRepository,
        private PerfilRepository $perfilRepository,

        private Transaction $transaction,
    )
    {
    }

    /**
     * @throws ConflictHttpException
     * @throws NotFoundHttpException
     * @throws InternalErrorException
     */
    public function execute(UsuarioInsercaoDto $usuarioInsercaoDto): Usuario
    {
        UsuarioValidators::validarEmailUnico($usuarioInsercaoDto->email, $this->usuarioRepository);
        $perfil = PerfilValidators::perfilIdExiste($usuarioInsercaoDto->perfilId, $this->perfilRepository);

        $senha = Senha::create($usuarioInsercaoDto->senha);

        $this->transaction->beginTransaction();

        try {
            $usuarioProps = new UsuarioProps(
                nome: $usuarioInsercaoDto->nome,
                email: $usuarioInsercaoDto->email,
                senha: $senha,
                ativo: true,
                emailVerificado: true,
                perfis: [$perfil]
            );

            $usuarioInserido = $this->usuarioRepository->inserir($usuarioProps);

            $this->usuarioRepository->gerenciarPerfis($usuarioInserido->id, [$perfil->id]);

            $this->transaction->commit();

            return $usuarioInserido;
        } catch (\Exception $e) {
            $this->transaction->rollback();

            throw new InternalErrorException($e->getMessage());
        }
    }
}
