<?php
declare(strict_types=1);

namespace Tests\Unit\Usuario\Infra\Eloquent\Mappers;

use App\Features\Usuario\Domain\Entities\Perfil;
use App\Features\Usuario\Infra\Eloquent\Mappers\PerfilMapper;
use App\Features\Usuario\Infra\Eloquent\Models\EloquentPerfilModel;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;
use Tests\Unit\UnitTestCase;

final class PerfilMapperTest extends UnitTestCase
{
    private function getEloquentPerfilModel(): EloquentPerfilModel
    {
        $model = new EloquentPerfilModel();

        $model->id = 1;
        $model->nome = 'Administrador';
        $model->chave = 'admin';
        $model->ativo = true;
        $model->data_criacao = '2024-01-01 00:00:00';

        return $model;
    }

    public function testDeveMapearPerfilCorretamenteComFrom(): void
    {
        $model = $this->getEloquentPerfilModel();

        $perfil = PerfilMapper::from($model);

        $this->assertInstanceOf(Perfil::class, $perfil);
        $this->assertSame('Administrador', $perfil->nome);
        $this->assertSame('admin', $perfil->chave);
    }

    public function testDeveLancarExcecaoSeNaoForEloquentPerfilModel(): void
    {
        $model = $this->createMock(Model::class);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Esperado EloquentPerfilModel.');

        PerfilMapper::from($model);
    }

    public function testOptionalDeveRetornarNullSeValorForNull(): void
    {
        $resultado = PerfilMapper::optional(null);

        $this->assertNull($resultado);
    }

    public function testOptionalDeveDelegarParaFromSeModelNaoForNull(): void
    {
        $model = $this->getEloquentPerfilModel();

        $perfil = PerfilMapper::optional($model);

        $this->assertInstanceOf(Perfil::class, $perfil);
    }

    public function testCollectionDeveMapearColecaoDeModelParaArrayDePerfis(): void
    {
        $model = $this->getEloquentPerfilModel();

        $perfis = PerfilMapper::collection([$model]);

        $this->assertCount(1, $perfis);
        $this->assertInstanceOf(Perfil::class, $perfis[0]);
    }

    public function testCollectionDeveRetornarArrayVazioSeColecaoForVazia(): void
    {
        $perfis = PerfilMapper::collection([]);

        $this->assertIsArray($perfis);
        $this->assertEmpty($perfis);
    }

    public function testCollectionDeveLancarExcecaoSeItemInvalidoForPassado(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Esperado EloquentPerfilModel.');

        PerfilMapper::collection([
            $this->createMock(Model::class)
        ]);
    }
}
