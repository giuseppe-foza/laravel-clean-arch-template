<?php

namespace App\Features\Base\Domain\ValueObjects;

final class Paginator
{
    public function __construct(
        public int $currentPage,
        public array $data,
        public int $from,
        public int $lastPage,
        public int $perPage,
        public int $total,
        public int $to,
    )
    {}
}
