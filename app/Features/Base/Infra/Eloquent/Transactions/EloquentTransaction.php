<?php

namespace App\Features\Base\Infra\Eloquent\Transactions;

use App\Features\Base\Application\Contracts\Transaction;
use Illuminate\Support\Facades\DB;

class EloquentTransaction implements Transaction
{
    public function beginTransaction(): void
    {
        DB::beginTransaction();
    }

    public function commit(): void
    {
        DB::commit();
    }

    public function rollback(): void
    {
        DB::rollBack();
    }
}
