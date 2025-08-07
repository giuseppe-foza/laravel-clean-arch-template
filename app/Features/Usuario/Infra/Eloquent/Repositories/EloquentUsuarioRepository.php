<?php
declare(strict_types=1);

namespace App\Features\Usuario\Infra\Eloquent\Repositories;

use App\Features\Base\Domain\Entities\Paginator;
use App\Features\Base\Domain\Props\PaginacaoOrdenacao;
use App\Features\Base\Infra\Eloquent\Mappers\PaginatorMapper;
use App\Features\Usuario\Domain\Entities\Usuario;
use App\Features\Usuario\Domain\Props\UsuarioFiltrosBusca;
use App\Features\Usuario\Domain\Props\UsuarioProps;
use App\Features\Usuario\Domain\Repositories\UsuarioRepository;
use App\Features\Usuario\Infra\Eloquent\Mappers\UsuarioMapper;
use App\Features\Usuario\Infra\Eloquent\Models\EloquentUsuarioModel;

readonly class EloquentUsuarioRepository implements UsuarioRepository
{
    public function __construct(
        private EloquentUsuarioModel $model,
    )
    {
    }

    public function listarTodos(
        UsuarioFiltrosBusca $usuarioFiltrosBusca,
        PaginacaoOrdenacao  $paginacaoOrdenacao,
    ): Paginator
    {
        $paginacao = $this->model->query()
            ->with(['perfis'])
            ->paginate(
                perPage: $paginacaoOrdenacao->getPorPagina(),
                page: $paginacaoOrdenacao->getPagina()
            );

        return PaginatorMapper::from($paginacao, fn ($model) => UsuarioMapper::from($model));
    }

    public function listarPorId(int $id): ?Usuario
    {
        $result = $this->model->query()->with(['perfis'])->where($this->model::ID, $id)->first();

        return UsuarioMapper::optional($result);
    }

    public function listarPorEmail(string $email): ?Usuario
    {
        $result = $this->model->query()->where($this->model::EMAIL, $email)->first();

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

        $usuarioInserido = $this->model->query()->create($dadosCriacao);

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
        $this->model->query()->find($id)->perfis()->sync($perfisId);
    }
}
