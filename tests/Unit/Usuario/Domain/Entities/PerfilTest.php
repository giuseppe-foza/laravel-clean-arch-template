<?php
declare(strict_types=1);

namespace Tests\Unit\Usuario\Domain\Entities;

use App\Features\Usuario\Domain\Entities\Perfil;
use App\Features\Usuario\Domain\Props\PerfilProps;
use Tests\Unit\Mocks\UsuarioDataBuilder;
use Tests\Unit\UnitTestCase;

class PerfilTest extends UnitTestCase
{
    private Perfil $sut;
    private int $id = 1;
    private PerfilProps $props;

    protected function setUp(): void {
        parent::setUp();

        $this->props = UsuarioDataBuilder::getPerfilProps();

        $this->sut = Perfil::reconstruct($this->props, $this->id);
    }

    public function testContrutorMetodoCreate(): void
    {
        $this->sut = Perfil::create($this->props);

        $this->assertEquals($this->props->nome, $this->sut->nome);
        $this->assertEquals($this->props->chave, $this->sut->chave);
        $this->assertEquals($this->props->ativo, $this->sut->ativo);
        $this->assertEquals($this->props->dataCriacao, $this->sut->dataCriacao);
    }

    public function testContrutorMetodoReconstruct(): void
    {
        $this->sut = Perfil::reconstruct($this->props, $this->id);

        $this->assertEquals($this->props->nome, $this->sut->nome);
        $this->assertEquals($this->props->chave, $this->sut->chave);
        $this->assertEquals($this->props->ativo, $this->sut->ativo);
        $this->assertEquals($this->props->dataCriacao, $this->sut->dataCriacao);
    }

    public function testGetterId(): void
    {
        $this->assertEquals($this->sut->id, $this->id);
        $this->assertIsInt($this->sut->id);
    }

    public function testGetterNome(): void
    {
        $this->assertEquals($this->sut->nome, $this->props->nome);
        $this->assertIsString($this->sut->nome);
    }

    public function testGetterChave(): void
    {
        $this->assertEquals($this->sut->chave, $this->props->chave);
        $this->assertIsString($this->sut->chave);
    }

    public function testGetterAtivo(): void
    {
        $this->assertEquals($this->sut->ativo, $this->props->ativo);
        $this->assertIsBool($this->sut->ativo);
    }

    public function testGetterDataCriacao(): void
    {
        $this->assertEquals($this->sut->dataCriacao, $this->props->dataCriacao);
        $this->assertIsString($this->sut->dataCriacao);
    }
}
