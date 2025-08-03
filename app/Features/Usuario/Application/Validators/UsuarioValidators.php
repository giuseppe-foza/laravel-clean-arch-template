<?php
declare(strict_types=1);

namespace App\Features\Usuario\Application\Validators;

use App\Features\Usuario\Domain\Entities\Usuario;
use App\Features\Usuario\Domain\Repositories\UsuarioRepository;
use App\Shared\Enums\MessagesEnum;
use App\Shared\Exceptions\ConflictHttpException;
use App\Shared\Exceptions\NotFoundHttpException;

final class UsuarioValidators
{
    /**
     * @throws NotFoundHttpException
     */
    public static function usuarioIdExiste(int $id, UsuarioRepository $usuarioRepository): Usuario
    {
        if(!$usuario = $usuarioRepository->listarPorId($id)) {
            throw new NotFoundHttpException(MessagesEnum::USUARIO_NAO_ENCONTRADO);
        }

        return $usuario;
    }

    /**
     * @throws ConflictHttpException
     */
    public static function validarEmailUnico(string $email, UsuarioRepository $usuarioRepository, ?int $id = null): void
    {
        $usuario = $usuarioRepository->listarPorEmail($email);

        $usuarioEmailJaExiste = $usuario && $usuario->id != $id;

        if($usuarioEmailJaExiste) {
            throw new ConflictHttpException(MessagesEnum::USUARIO_EMAIL_JA_EXISTE);
        }
    }
}
