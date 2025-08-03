<?php
declare(strict_types=1);

namespace App\Features\Usuario\Infra\Eloquent\Repositories;

use App\Features\Usuario\Domain\Entities\Perfil;
use App\Features\Usuario\Domain\Repositories\PerfilRepository;
use App\Features\Usuario\Infra\Eloquent\Mappers\PerfilMapper;
use App\Features\Usuario\Infra\Eloquent\Mappers\UsuarioMapper;
use App\Features\Usuario\Infra\Eloquent\Models\EloquentPerfilModel;
use App\Features\Usuario\Infra\Eloquent\Models\EloquentUsuarioModel;

readonly class EloquentPerfilRepository implements PerfilRepository
{
    public function __construct(
        private EloquentPerfilModel $model,
    )
    {
    }

    public function listarPorId(int $id): ?Perfil
    {
        $result = $this->model->where($this->model::ID, $id)->first();

        return PerfilMapper::optional($result);
    }

    public function listarPorChave(string $chave): ?Perfil
    {
        $result = $this->model->where($this->model::CHAVE, $chave)->first();

        return PerfilMapper::optional($result);
    }
}
