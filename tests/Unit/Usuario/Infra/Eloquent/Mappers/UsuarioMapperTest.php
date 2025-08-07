<?php
declare(strict_types=1);

namespace Tests\Unit\Usuario\Infra\Eloquent\Mappers;

use App\Features\Usuario\Domain\Entities\Usuario;
use App\Features\Usuario\Domain\ValueObjects\Senha;
use App\Features\Usuario\Infra\Eloquent\Mappers\UsuarioMapper;
use App\Features\Usuario\Infra\Eloquent\Models\EloquentPerfilModel;
use App\Features\Usuario\Infra\Eloquent\Models\EloquentUsuarioModel;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;
use Tests\Unit\UnitTestCase;

final class UsuarioMapperTest extends UnitTestCase
{
    public function getEloquentUsuarioModel(): EloquentUsuarioModel
    {
        $model = new EloquentUsuarioModel();

        $model->id = 1;
        $model->nome = 'João';
        $model->email = 'joao@email.com';
        $model->senha = Senha::create('123456')->toValue();
        $model->ativo = true;
        $model->email_verificado = true;
        $model->data_criacao = '2024-01-01 00:00:00';
        $model->perfis = [];

        return $model;
    }

    public function testDeveMapearUsuarioCorretamenteComFrom(): void
    {
        $model = $this->getEloquentUsuarioModel();

        $usuario = UsuarioMapper::from($model);

        $this->assertInstanceOf(Usuario::class, $usuario);
        $this->assertSame('João', $usuario->nome);
        $this->assertSame('joao@email.com', $usuario->email);
    }

    public function testDeveLancarExcecaoSeNaoForEloquentUsuarioModel(): void
    {
        $model = new EloquentPerfilModel();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Esperado EloquentUsuarioModel.');

        UsuarioMapper::from($model);
    }

    public function testOptionalDeveRetornarNullSeValorForNull(): void
    {
        $resultado = UsuarioMapper::optional(null);

        $this->assertNull($resultado);
    }

    public function testOptionalDeveDelegarParaFromSeModelNaoForNull(): void
    {
        $model = $this->getEloquentUsuarioModel();

        $usuario = UsuarioMapper::from($model);

        $this->assertInstanceOf(Usuario::class, $usuario);
    }

    public function testCollectionDeveMapearColecaoDeModelParaArrayDeUsuarios(): void
    {
        $model = $this->getEloquentUsuarioModel();

        $usuarios = UsuarioMapper::collection([$model]);

        $this->assertCount(1, $usuarios);
        $this->assertInstanceOf(Usuario::class, $usuarios[0]);
    }

    public function testCollectionDeveRetornarArrayVazioSeColecaoForVazia(): void
    {
        $usuarios = UsuarioMapper::collection([]);

        $this->assertIsArray($usuarios);
        $this->assertEmpty($usuarios);
    }

    public function testCollectionDeveLancarExcecaoSeItemInvalidoForPassado(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Esperado EloquentUsuarioModel.');

        UsuarioMapper::collection([
            $this->createMock(Model::class) // inválido
        ]);
    }
}
