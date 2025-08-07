<?php
declare(strict_types=1);

namespace Tests\Unit\Usuario\Application\UseCases;

use App\Features\Usuario\Application\UseCases\UsuarioListagemPorIdUseCase;
use App\Features\Usuario\Domain\Entities\Usuario;
use App\Features\Usuario\Domain\Repositories\UsuarioRepository;
use App\Shared\Enums\MessagesEnum;
use App\Shared\Exceptions\NotFoundHttpException;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\HttpFoundation\Response;
use Tests\Unit\Mocks\UsuarioDataBuilder;
use Tests\Unit\UnitTestCase;

class UsuarioListagemPorIdUseCaseTest extends UnitTestCase
{
    private UsuarioListagemPorIdUseCase $sut;
    private MockObject|UsuarioRepository $usuarioRepositoryMock;

    protected function setUp(): void {
        parent::setUp();

        $this->usuarioRepositoryMock = $this->createMock(UsuarioRepository::class);

        $this->sut = new UsuarioListagemPorIdUseCase($this->usuarioRepositoryMock);
    }

    public function testDeveRetornarUsuarioPorId(): void
    {
        $this->usuarioRepositoryMock
            ->method('listarPorId')
            ->willReturn(Usuario::reconstruct(UsuarioDataBuilder::getUsuarioProps(), 1));

        $usuario = $this->sut->execute(1);

        $this->assertInstanceOf(Usuario::class, $usuario);
    }

    public function testDeveRetornarExcecaoSeUsuarioNaoExistir()
    {
        $this->usuarioRepositoryMock
            ->expects($this->once())
            ->method('listarPorId')
            ->willReturn(null);

        $this->expectException(NotFoundHttpException::class);
        $this->expectExceptionCode(Response::HTTP_NOT_FOUND);
        $this->expectExceptionMessage(MessagesEnum::USUARIO_NAO_ENCONTRADO);

        $this->sut->execute(1);
    }
}
