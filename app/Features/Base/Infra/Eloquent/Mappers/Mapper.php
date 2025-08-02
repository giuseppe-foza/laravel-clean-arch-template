<?php
declare(strict_types=1);

namespace App\Features\Base\Infra\Eloquent\Mappers;

use App\Features\Base\Domain\Entities\BaseEntity;
use Illuminate\Database\Eloquent\Model;

abstract class Mapper
{
    /**
     * @param mixed $model
     * @return mixed
     */
    abstract public static function from(Model $model): BaseEntity;

    public static function optional(?Model $model = null): ?BaseEntity
    {
        return $model ? static::from($model) : null;
    }

    public static function collection(iterable $collection): array
    {
        $result = [];
        foreach ($collection as $item) {
            $result[] = static::from($item);
        }
        return $result;
    }
}
