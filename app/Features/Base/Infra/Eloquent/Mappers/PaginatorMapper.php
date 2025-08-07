<?php
declare(strict_types=1);

namespace App\Features\Base\Infra\Eloquent\Mappers;

use App\Features\Base\Domain\Entities\Paginator;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class PaginatorMapper
{
    /**
     * @template TModel
     * @template TDomain
     * @param LengthAwarePaginator<TModel> $paginator
     * @param callable(TModel): TDomain $mapper
     * @return Paginator<TDomain>
     */
    public static function from(LengthAwarePaginator $paginator, callable $mapper): Paginator
    {
        $mappedItems = array_map($mapper, $paginator->items());

        return Paginator::paginate(
            paginationCurrentPage: $paginator->currentPage(),
            paginationData: $mappedItems,
            paginationFrom: $paginator->firstItem() ?? 0,
            paginationLastPage: $paginator->lastPage(),
            paginationPerPage: $paginator->perPage(),
            paginationTo: $paginator->lastItem() ?? 0,
            paginationTotal: $paginator->total(),
        );
    }
}
