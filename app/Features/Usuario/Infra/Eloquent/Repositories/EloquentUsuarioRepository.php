<?php
declare(strict_types=1);

namespace App\Features\Usuario\Infra\Eloquent\Repositories;

use App\Features\Usuario\Domain\Entities\Usuario;
use App\Features\Usuario\Domain\Props\UsuarioProps;
use App\Features\Usuario\Domain\Repositories\UsuarioRepository;
use App\Features\Usuario\Infra\Eloquent\Mappers\UsuarioMapper;
use App\Features\Usuario\Infra\Eloquent\Models\EloquentUsuarioModel;
use Illuminate\Support\Collection;

readonly class EloquentUsuarioRepository implements UsuarioRepository
{
    public function __construct(
        private EloquentUsuarioModel $model,
    )
    {
    }

    public function listarTodos(): array
    {
        $result = $this->model->with(['perfis'])->get();

        return UsuarioMapper::collection($result);
    }

    public function listarPorId(int $id): ?Usuario
    {
        $result = $this->model->with(['perfis'])->where($this->model::ID, $id)->first();

        return UsuarioMapper::optional($result);
    }

    public function listarPorEmail(string $email): ?Usuario
    {
        $result = $this->model->where($this->model::EMAIL, $email)->first();

        return UsuarioMapper::optional($result);
    }

    public function inserir(UsuarioProps $usuarioProps): Usuario
    {
        $dadosCriacao = [
            EloquentUsuarioModel::NOME => $usuarioProps->nome,
            EloquentUsuarioModel::EMAIL => $usuarioProps->email,
            EloquentUsuarioModel::SENHA => $usuarioProps->senha,
            EloquentUsuarioModel::ATIVO => $usuarioProps->ativo,
            EloquentUsuarioModel::EMAIL_VERIFICADO => true,
        ];

        $usuarioInserido = $this->model->create($dadosCriacao);

        return Usuario::reconstruct($usuarioProps, $usuarioInserido->id);
    }

    public function atualizar(Usuario $usuario): Usuario
    {
        $dadosEdicao = [
            EloquentUsuarioModel::NOME => $usuario->nome,
            EloquentUsuarioModel::EMAIL => $usuario->email,
        ];

        $this->model->where(EloquentUsuarioModel::ID, $usuario->id)->update($dadosEdicao);

        return $usuario;
    }

    public function gerenciarPerfis(int $id, array $perfisId): void
    {
        $this->model->find($id)->perfis()->sync($perfisId);
    }
}
