<?php
declare(strict_types=1);

namespace App\Features\Usuario\Infra\Eloquent\Mappers;

use App\Features\Base\Domain\ValueObjects\Date;
use App\Features\Base\Infra\Eloquent\Mappers\Mapper;
use App\Features\Usuario\Domain\Entities\Usuario;
use App\Features\Usuario\Domain\Props\UsuarioProps;
use App\Features\Usuario\Domain\ValueObjects\Senha;
use App\Features\Usuario\Infra\Eloquent\Models\EloquentUsuarioModel;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

final class UsuarioMapper extends Mapper
{
    public static function from(Model $model): Usuario
    {
        if (!$model instanceof EloquentUsuarioModel) {
            throw new InvalidArgumentException('Esperado EloquentUsuarioModel.');
        }

        $perfis = $model->relationLoaded('perfis') ?
            PerfilMapper::collection($model->perfis) : [];

        return Usuario::reconstruct(
            new UsuarioProps(
                nome: $model->nome,
                email: $model->email,
                senha: Senha::list($model->senha),
                ativo: $model->ativo,
                emailVerificado: $model->email_verificado ?? null,
                dataCriacao: Date::create($model->getRawOriginal($model::DATA_CRIACAO))->toValue(),
                perfis: $perfis,
            ),
            $model->id
        );
    }

    public static function optional(?Model $model = null): ?Usuario
    {
        if (null === $model) return null;

        return self::from($model);
    }
}
