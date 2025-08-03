<?php
declare(strict_types=1);

namespace App\Features\Base\Infra\Eloquent\Mappers;

use App\Features\Base\Domain\Entities\BaseEntity;
use Illuminate\Database\Eloquent\Model;

abstract class Mapper
{
    abstract public static function from(Model $model): BaseEntity;
    abstract public static function optional(?Model $model = null): ?BaseEntity;

    public static function collection(iterable $collection): array
    {
        $result = [];
        foreach ($collection as $item) {
            $result[] = static::from($item);
        }
        return $result;
    }
}
