<?php
declare(strict_types=1);

namespace App\Features\Usuario\Domain\Repositories;

use App\Features\Base\Domain\Entities\Paginator;
use App\Features\Base\Domain\Props\PaginacaoOrdenacao;
use App\Features\Usuario\Domain\Entities\Usuario;
use App\Features\Usuario\Domain\Props\UsuarioFiltrosBusca;
use App\Features\Usuario\Domain\Props\UsuarioProps;

interface UsuarioRepository
{
    public function listarTodos(
        UsuarioFiltrosBusca $usuarioFiltrosBusca,
        PaginacaoOrdenacao  $paginacaoOrdenacao,
    ): Paginator;
    public function listarPorId(int $id): ?Usuario;
    public function listarPorEmail(string $email): ?Usuario;
    public function inserir(UsuarioProps $usuarioProps): Usuario;
    public function atualizar(Usuario $usuario): Usuario;
    public function gerenciarPerfis(int $usuarioId, array $perfisId): void;
}
