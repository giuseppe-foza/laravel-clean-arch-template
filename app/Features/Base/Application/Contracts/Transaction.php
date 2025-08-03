<?php
declare(strict_types=1);

namespace App\Features\Base\Application\Contracts;

interface Transaction
{
    public function beginTransaction(): void;
    public function commit(): void;
    public function rollback(): void;
}
