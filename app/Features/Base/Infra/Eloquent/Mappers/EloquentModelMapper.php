<?php
declare(strict_types=1);

namespace App\Features\Base\Infra\Eloquent\Mappers;

use App\Features\Base\Domain\Entities\BaseEntity;
use App\Features\Base\Domain\ValueObjects\Paginator;
use App\Features\Base\Infra\Eloquent\Models\BaseModel;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Collection;

abstract class EloquentModelMapper
{
    abstract public function from(BaseModel $model): ?BaseEntity;

    public function collection(Collection $model): Collection {
        return $model->map(fn($item) => $this->from($item));
    }

    public function pagination(QueryBuilder|EloquentBuilder $builder, int $page, int $perPage): Paginator
    {
        $paginator = $builder->paginate(
            $perPage,
            ['*'],
            'page',
            $page,
        );

        if($paginator->getCollection()->isNotEmpty())
        {
            $paginator->getCollection()->transform(fn($item) => $this->from($item));
        }

        return new Paginator(
            currentPage: $paginator->currentPage(),
            data: $paginator->items(),
            from: $paginator->firstItem(),
            lastPage: $paginator->lastPage(),
            perPage: $paginator->perPage(),
            total: $paginator->total(),
            to: $paginator->lastItem(),
        );
    }
}
