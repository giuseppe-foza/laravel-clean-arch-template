<?php
declare(strict_types=1);

namespace App\Features\Usuario\Application\Validators;

use App\Features\Usuario\Domain\Entities\Perfil;
use App\Features\Usuario\Domain\Repositories\PerfilRepository;
use App\Shared\Enums\MessagesEnum;
use App\Shared\Exceptions\NotFoundHttpException;

final class PerfilValidators
{
    /**
     * @throws NotFoundHttpException
     */
    public static function perfilIdExiste(int $id, PerfilRepository $perfilRepository): Perfil
    {
        if(!$perfil = $perfilRepository->listarPorId($id)) {
            throw new NotFoundHttpException(MessagesEnum::PERFIL_NAO_ENCONTRADO);
        }

        return $perfil;
    }
}
