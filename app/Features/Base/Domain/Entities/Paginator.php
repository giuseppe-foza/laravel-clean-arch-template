<?php
declare(strict_types=1);

namespace App\Features\Base\Domain\Entities;

final class Paginator
{
    private function __construct(
        private readonly int   $paginationCurrentPage,
        private readonly array $paginationData,
        private readonly int   $paginationFrom,
        private readonly int   $paginationLastPage,
        private readonly int   $paginationPerPage,
        private readonly int   $paginationTo,
        private readonly int   $paginationTotal,
    )
    {
    }

    public int $currentPage {
        get => $this->paginationCurrentPage;
    }

    public array $data {
        get => $this->paginationData;
    }

    public int $from {
        get => $this->paginationFrom;
    }

    public int $lastPage {
        get => $this->paginationLastPage;
    }

    public int $perPage {
        get => $this->paginationPerPage;
    }

    public int $to {
        get => $this->paginationTo;
    }

    public int $total {
        get => $this->paginationTotal;
    }

    public static function paginate(
        int   $paginationCurrentPage,
        array $paginationData,
        int   $paginationFrom,
        int   $paginationLastPage,
        int   $paginationPerPage,
        int   $paginationTo,
        int   $paginationTotal,
    ): Paginator
    {
        return new self(
            $paginationCurrentPage,
            $paginationData,
            $paginationFrom,
            $paginationLastPage,
            $paginationPerPage,
            $paginationTo,
            $paginationTotal,
        );
    }
}
