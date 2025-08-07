<?php
declare(strict_types=1);

namespace Tests\Unit\Usuario\Application\UseCases;

use App\Features\Base\Domain\Entities\Paginator;
use App\Features\Base\Domain\Props\PaginacaoOrdenacao;
use App\Features\Usuario\Application\Dto\UsuarioFiltrosBuscaDto;
use App\Features\Usuario\Application\UseCases\UsuarioListagemUseCase;
use App\Features\Usuario\Domain\Props\UsuarioFiltrosBusca;
use App\Features\Usuario\Domain\Repositories\UsuarioRepository;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\Unit\UnitTestCase;

class UsuarioListagemUseCaseTest extends UnitTestCase
{
    private UsuarioListagemUseCase $sut;
    private MockObject|UsuarioRepository $usuarioRepositoryMock;
    private UsuarioFiltrosBuscaDto $usuarioFiltrosBuscaDtoMock;

    protected function setUp(): void {
        parent::setUp();

        $this->usuarioRepositoryMock = $this->createMock(UsuarioRepository::class);

        $this->sut = new UsuarioListagemUseCase($this->usuarioRepositoryMock);

        $this->usuarioFiltrosBuscaDtoMock = new UsuarioFiltrosBuscaDto(
            new UsuarioFiltrosBusca(),
            new PaginacaoOrdenacao()
        );
    }

    public function testDeveRetornarListaDeUsuariosComPaginacao(): void
    {
        $paginacao = Paginator::paginate(
            paginationCurrentPage: 1,
            paginationData: [],
            paginationFrom: 1,
            paginationLastPage: 1,
            paginationPerPage: 10,
            paginationTo: 1,
            paginationTotal: 1,
        );

        $this->usuarioRepositoryMock
            ->method('listarTodos')
            ->willReturn($paginacao);

        $usuariosPaginacao = $this->sut->execute($this->usuarioFiltrosBuscaDtoMock);

        $this->assertInstanceOf(Paginator::class, $usuariosPaginacao);
    }
}
