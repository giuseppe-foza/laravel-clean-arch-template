<?php
declare(strict_types=1);

namespace App\Features\Usuario\Infra\Providers;

use App\Features\Base\Infra\Providers\AppServiceProvider;
use App\Features\Usuario\Application\Contracts\UsuarioEdicaoUseCaseInterface;
use App\Features\Usuario\Application\Contracts\UsuarioInsercaoUseCaseInterface;
use App\Features\Usuario\Application\Contracts\UsuarioListagemPorIdUseCaseInterface;
use App\Features\Usuario\Application\Contracts\UsuarioListagemUseCaseInterface;
use App\Features\Usuario\Application\UseCases\UsuarioEdicaoUseCase;
use App\Features\Usuario\Application\UseCases\UsuarioInsercaoUseCase;
use App\Features\Usuario\Application\UseCases\UsuarioListagemPorIdUseCase;
use App\Features\Usuario\Application\UseCases\UsuarioListagemUseCase;
use App\Features\Usuario\Domain\Repositories\PerfilRepository;
use App\Features\Usuario\Domain\Repositories\UsuarioRepository;
use App\Features\Usuario\Infra\Eloquent\Repositories\EloquentPerfilRepository;
use App\Features\Usuario\Infra\Eloquent\Repositories\EloquentUsuarioRepository;
use App\Features\Usuario\Infra\Memory\MemoryUsuarioRepository;

class UsuarioProviders extends AppServiceProvider
{
    public array $bindings = [
        /*
         * Repositories
         */
        UsuarioRepository::class => EloquentUsuarioRepository::class,
//        UsuarioRepository::class => MemoryUsuarioRepository::class,
        PerfilRepository::class => EloquentPerfilRepository::class,

        /*
         * UseCases
         */
        UsuarioListagemUseCaseInterface::class => UsuarioListagemUseCase::class,
        UsuarioListagemPorIdUseCaseInterface::class => UsuarioListagemPorIdUseCase::class,
        UsuarioInsercaoUseCaseInterface::class => UsuarioInsercaoUseCase::class,
        UsuarioEdicaoUseCaseInterface::class => UsuarioEdicaoUseCase::class,
    ];
}
