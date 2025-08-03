<?php
declare(strict_types=1);

namespace App\Features\Usuario\Infra\Eloquent\Mappers;

use App\Features\Base\Domain\ValueObjects\Date;
use App\Features\Base\Infra\Eloquent\Mappers\Mapper;
use App\Features\Usuario\Domain\Entities\Perfil;
use App\Features\Usuario\Domain\Props\PerfilProps;
use App\Features\Usuario\Infra\Eloquent\Models\EloquentPerfilModel;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

class PerfilMapper extends Mapper
{
    public static function from(Model $model): Perfil
    {
        if (!$model instanceof EloquentPerfilModel) {
            throw new InvalidArgumentException('Esperado EloquentPerfilModel.');
        }

        $props = new PerfilProps(
            nome: $model->nome,
            chave: $model->chave,
            ativo: $model->ativo,
            dataCriacao: Date::create($model->getRawOriginal($model::DATA_CRIACAO))->toValue(),
        );

        return Perfil::reconstruct($props, $model->id);
    }

    public static function optional(?Model $model = null): ?Perfil
    {
        if (null === $model) return null;

        return self::from($model);
    }
}
