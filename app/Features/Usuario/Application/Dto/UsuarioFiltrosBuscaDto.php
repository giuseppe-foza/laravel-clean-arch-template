<?php
declare(strict_types=1);

namespace App\Features\Usuario\Application\Dto;

use App\Features\Base\Domain\Props\PaginacaoOrdenacao;
use App\Features\Usuario\Domain\Props\UsuarioFiltrosBusca;

final readonly class UsuarioFiltrosBuscaDto
{
    public function __construct(
        public UsuarioFiltrosBusca $usuarioFiltrosBusca,
        public PaginacaoOrdenacao  $paginacaoOrdenacao,
    ) {}
}
