<?php
declare(strict_types=1);

namespace Tests\Unit\Usuario\Application\UseCases;

use App\Features\Base\Application\Contracts\Transaction;
use App\Features\Usuario\Application\Dto\UsuarioInsercaoDto;
use App\Features\Usuario\Application\UseCases\UsuarioInsercaoUseCase;
use App\Features\Usuario\Domain\Entities\Perfil;
use App\Features\Usuario\Domain\Entities\Usuario;
use App\Features\Usuario\Domain\Repositories\PerfilRepository;
use App\Features\Usuario\Domain\Repositories\UsuarioRepository;
use App\Shared\Enums\MessagesEnum;
use App\Shared\Exceptions\ConflictHttpException;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\HttpFoundation\Response;
use Tests\Unit\Mocks\UsuarioDataBuilder;
use Tests\Unit\UnitTestCase;

class UsuarioInsercaoUseCaseTest extends UnitTestCase
{
    private UsuarioInsercaoUseCase $sut;
    private MockObject|UsuarioRepository $usuarioRepositoryMock;
    private MockObject|PerfilRepository $perfilRepositoryMock;
    private MockObject|Transaction $transactionMock;
    private UsuarioInsercaoDto $usuarioInsercaoDto;

    protected function setUp(): void
    {
        $this->usuarioRepositoryMock = $this->createMock(UsuarioRepository::class);
        $this->perfilRepositoryMock = $this->createMock(PerfilRepository::class);
        $this->transactionMock = $this->createMock(Transaction::class);

        $this->usuarioInsercaoDto = new UsuarioInsercaoDto();

        $this->usuarioInsercaoDto->nome = 'nome';
        $this->usuarioInsercaoDto->email = 'email@email.com';
        $this->usuarioInsercaoDto->senha = 'senha';
        $this->usuarioInsercaoDto->perfilId = 1;

        $this->sut = new UsuarioInsercaoUseCase(
            $this->usuarioRepositoryMock,
            $this->perfilRepositoryMock,
            $this->transactionMock
        );
    }

    public function testDeveCriarUmUsuario(): void
    {
        $usuarioMock = Usuario::reconstruct(UsuarioDataBuilder::getUsuarioProps(), 1);
        $perfilMock = Perfil::reconstruct(UsuarioDataBuilder::getPerfilProps(), 1);

        $this->perfilRepositoryMock
            ->expects($this->once())
            ->method('listarPorId')
            ->willReturn($perfilMock);

        $this->usuarioRepositoryMock
            ->expects($this->once())
            ->method('listarPorEmail')
            ->willReturn(null);

        $this->usuarioRepositoryMock
            ->expects($this->once())
            ->method('inserir')
            ->willReturn($usuarioMock);

        $this->usuarioRepositoryMock
            ->expects($this->once())
            ->method('gerenciarPerfis')
            ->with($usuarioMock->id, [1]);

        $this->transactionMock->expects($this->once())->method('beginTransaction');
        $this->transactionMock->expects($this->once())->method('commit');

        $usuario = $this->sut->execute($this->usuarioInsercaoDto);

        $this->assertInstanceOf(Usuario::class, $usuario);
    }

    public function testDeveRetornarExcecaoSeEmailJaExistir(): void
    {
        $usuarioMock = Usuario::reconstruct(UsuarioDataBuilder::getUsuarioProps(), 1);

        $this->usuarioRepositoryMock
            ->expects($this->once())
            ->method('listarPorEmail')
            ->willReturn($usuarioMock);

        $this->expectException(ConflictHttpException::class);
        $this->expectExceptionCode(Response::HTTP_CONFLICT);
        $this->expectExceptionMessage(MessagesEnum::USUARIO_EMAIL_JA_EXISTE);

        $this->sut->execute($this->usuarioInsercaoDto);
    }
}
