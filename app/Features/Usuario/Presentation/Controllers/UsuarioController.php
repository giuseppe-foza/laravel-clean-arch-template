<?php
declare(strict_types=1);

namespace App\Features\Usuario\Presentation\Controllers;

use App\Features\Usuario\Application\UseCases\UsuarioListagemUseCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

readonly class UsuarioController
{
    public function __construct(
        private UsuarioListagemUseCase $usuarioListagemUseCase,
    )
    {
    }

    public function listarTodos(): JsonResponse
    {
        $usuarios = $this->usuarioListagemUseCase->execute();

        return response()->json($usuarios, Response::HTTP_OK);
    }
}
