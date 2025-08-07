<?php
declare(strict_types=1);

namespace Tests\Unit\Usuario\Application\UseCases;

use App\Features\Base\Application\Contracts\Transaction;
use App\Features\Base\Domain\ValueObjects\Date;
use App\Features\Usuario\Application\Dto\UsuarioEdicaoDto;
use App\Features\Usuario\Application\UseCases\UsuarioEdicaoUseCase;
use App\Features\Usuario\Domain\Entities\Perfil;
use App\Features\Usuario\Domain\Entities\Usuario;
use App\Features\Usuario\Domain\Props\UsuarioProps;
use App\Features\Usuario\Domain\Repositories\PerfilRepository;
use App\Features\Usuario\Domain\Repositories\UsuarioRepository;
use App\Features\Usuario\Domain\ValueObjects\Senha;
use App\Shared\Enums\MessagesEnum;
use App\Shared\Exceptions\ConflictHttpException;
use App\Shared\Exceptions\NotFoundHttpException;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\HttpFoundation\Response;
use Tests\Unit\Mocks\UsuarioDataBuilder;
use Tests\Unit\UnitTestCase;

class UsuarioEdicaoUseCaseTest extends UnitTestCase
{
    private UsuarioEdicaoUseCase $sut;
    private MockObject|UsuarioRepository $usuarioRepositoryMock;
    private MockObject|PerfilRepository $perfilRepositoryMock;
    private MockObject|Transaction $transactionMock;
    private UsuarioEdicaoDto $usuarioEdicaoDto;

    protected function setUp(): void
    {
        $this->usuarioRepositoryMock = $this->createMock(UsuarioRepository::class);
        $this->perfilRepositoryMock = $this->createMock(PerfilRepository::class);
        $this->transactionMock = $this->createMock(Transaction::class);

        $this->usuarioEdicaoDto = new UsuarioEdicaoDto();

        $this->usuarioEdicaoDto->nome = 'nome';
        $this->usuarioEdicaoDto->email = 'email@email.com';
        $this->usuarioEdicaoDto->senha = 'senha';
        $this->usuarioEdicaoDto->perfilId = 1;

        $this->sut = new UsuarioEdicaoUseCase(
            $this->usuarioRepositoryMock,
            $this->perfilRepositoryMock,
            $this->transactionMock
        );
    }

    public function testDeveEditarUnicoUsuario(): void
    {
        $usuarioMock = Usuario::reconstruct(UsuarioDataBuilder::getUsuarioProps(), 1);
        $perfilMock = Perfil::reconstruct(UsuarioDataBuilder::getPerfilProps(), 1);

        $this->usuarioRepositoryMock
            ->expects($this->once())
            ->method('listarPorId')
            ->willReturn($usuarioMock);

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
            ->method('atualizar')
            ->willReturn($usuarioMock);

        $this->usuarioRepositoryMock
            ->expects($this->once())
            ->method('gerenciarPerfis')
            ->with($usuarioMock->id, [1]);

        $this->transactionMock->expects($this->once())->method('beginTransaction');
        $this->transactionMock->expects($this->once())->method('commit');

        $usuario = $this->sut->execute(1, $this->usuarioEdicaoDto);

        $this->assertInstanceOf(Usuario::class, $usuario);
    }

    public function testDeveRetornarExcecaoSeUsuarioNaoExistir(): void
    {
        $usuarioMock = Usuario::reconstruct(UsuarioDataBuilder::getUsuarioProps(), 1);

        $this->usuarioRepositoryMock
            ->expects($this->once())
            ->method('listarPorId')
            ->willReturn($usuarioMock);

        $this->perfilRepositoryMock
            ->expects($this->once())
            ->method('listarPorId')
            ->willReturn(null);

        $this->expectException(NotFoundHttpException::class);
        $this->expectExceptionCode(Response::HTTP_NOT_FOUND);
        $this->expectExceptionMessage(MessagesEnum::PERFIL_NAO_ENCONTRADO);

        $this->sut->execute(1, $this->usuarioEdicaoDto);
    }

    public function testDeveRetornarExcecaoSePerfilNaoExistir(): void
    {
        $this->usuarioRepositoryMock
            ->expects($this->once())
            ->method('listarPorId')
            ->willReturn(null);

        $this->expectException(NotFoundHttpException::class);
        $this->expectExceptionCode(Response::HTTP_NOT_FOUND);
        $this->expectExceptionMessage(MessagesEnum::USUARIO_NAO_ENCONTRADO);

        $this->sut->execute(1, $this->usuarioEdicaoDto);
    }

    public function testDeveRetornarExcecaoSeEmailJaExistir(): void
    {
        $usuario1Mock = Usuario::reconstruct(UsuarioDataBuilder::getUsuarioProps(), 1);

        $usuario2Mock = Usuario::reconstruct(new UsuarioProps(
            nome: 'Teste',
            email: 'teste2@email.com',
            senha: Senha::create('senha'),
            ativo: true,
            emailVerificado: true,
            dataCriacao: Date::now()->toValue(),
            perfis: []
        ), 2);

        $perfilMock = Perfil::reconstruct(UsuarioDataBuilder::getPerfilProps(), 1);

        $this->usuarioRepositoryMock
            ->expects($this->once())
            ->method('listarPorId')
            ->willReturn($usuario1Mock);

        $this->perfilRepositoryMock
            ->expects($this->once())
            ->method('listarPorId')
            ->willReturn($perfilMock);

        $this->usuarioRepositoryMock
            ->expects($this->once())
            ->method('listarPorEmail')
            ->willReturn($usuario2Mock);

        $this->expectException(ConflictHttpException::class);
        $this->expectExceptionCode(Response::HTTP_CONFLICT);
        $this->expectExceptionMessage(MessagesEnum::USUARIO_EMAIL_JA_EXISTE);

        $this->sut->execute(1, $this->usuarioEdicaoDto);
    }
}
