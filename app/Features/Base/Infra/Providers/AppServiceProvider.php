<?php

namespace App\Features\Base\Infra\Providers;

use App\Features\Base\Application\Contracts\Transaction;
use App\Features\Base\Infra\Eloquent\Transactions\EloquentTransaction;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public array $bindings = [];
    public array $singletons = [];

    public function register(): void
    {
        $this->app->bind(
            Transaction::class,
            EloquentTransaction::class,
        );
    }

    public function boot(): void
    {
    }
}
