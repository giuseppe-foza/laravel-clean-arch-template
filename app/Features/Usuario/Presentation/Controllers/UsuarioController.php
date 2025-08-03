<?php

namespace App\Features\Usuario\Presentation\Controllers;

use App\Features\Base\Presentation\FormRequest\IdValidator;
use App\Features\Usuario\Application\Contracts\UsuarioEdicaoUseCaseInterface;
use App\Features\Usuario\Application\Contracts\UsuarioInsercaoUseCaseInterface;
use App\Features\Usuario\Application\Contracts\UsuarioListagemPorIdUseCaseInterface;
use App\Features\Usuario\Application\Contracts\UsuarioListagemUseCaseInterface;
use App\Features\Usuario\Application\Dto\UsuarioEdicaoDto;
use App\Features\Usuario\Application\Dto\UsuarioInsercaoDto;
use App\Features\Usuario\Presentation\Validators\UsuarioEdicaoValidator;
use App\Features\Usuario\Presentation\Validators\UsuarioInsercaoValidator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

readonly class UsuarioController
{
    public function __construct(
        private UsuarioListagemUseCaseInterface $usuarioListagemUseCase,
        private UsuarioListagemPorIdUseCaseInterface $usuarioListagemPorIdUseCaseInterface,
        private UsuarioInsercaoUseCaseInterface $usuarioInsercaoUseCase,
        private UsuarioEdicaoUseCaseInterface $usuarioEdicaoUseCase,
    )
    {
    }

    public function listarTodos(): JsonResponse
    {
        $usuarios = $this->usuarioListagemUseCase->execute();

        return response()->json($usuarios, Response::HTTP_OK);
    }

    public function listarPorId(IdValidator $request): JsonResponse
    {
        $id = $request->route('id');

        $usuario = $this->usuarioListagemPorIdUseCaseInterface->execute($id);

        return response()->json($usuario, Response::HTTP_OK);
    }

    public function inserir(UsuarioInsercaoValidator $request, UsuarioInsercaoDto $dto): JsonResponse
    {
        $dto->nome     = $request->input('nome');
        $dto->email    = $request->input('email');
        $dto->senha    = $request->input('senha');
        $dto->perfilId = (int) $request->input('perfilId');

        $usuario = $this->usuarioInsercaoUseCase->execute($dto);

        return response()->json($usuario, Response::HTTP_CREATED);
    }

    public function editar(UsuarioEdicaoValidator $request, UsuarioEdicaoDto $dto): JsonResponse
    {
        $dto->nome     = $request->input('nome');
        $dto->email    = $request->input('email');
        $dto->perfilId = (int) $request->input('perfilId');

        $id = (int) $request->route('id');

        $usuario = $this->usuarioEdicaoUseCase->execute($id, $dto);

        return response()->json($usuario, Response::HTTP_OK);
    }
}
