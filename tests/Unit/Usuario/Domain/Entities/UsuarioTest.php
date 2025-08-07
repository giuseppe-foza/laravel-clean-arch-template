<?php
declare(strict_types=1);

namespace Tests\Unit\Usuario\Domain\Entities;

use App\Features\Usuario\Domain\Entities\Usuario;
use App\Features\Usuario\Domain\Props\UsuarioProps;
use App\Features\Usuario\Domain\ValueObjects\Senha;
use Tests\Unit\Mocks\UsuarioDataBuilder;
use Tests\Unit\UnitTestCase;

class UsuarioTest extends UnitTestCase
{
    private Usuario $sut;
    private int $id = 1;
    private UsuarioProps $props;

    protected function setUp(): void {
        parent::setUp();

        $this->props = UsuarioDataBuilder::getUsuarioProps();

        $this->sut = Usuario::reconstruct($this->props, $this->id);
    }

    public function testContrutorMetodoCreate(): void
    {
        $this->sut = Usuario::create($this->props);

        $this->assertEquals($this->props->nome, $this->sut->nome);
        $this->assertEquals($this->props->email, $this->sut->email);
        $this->assertEquals($this->props->senha, $this->sut->getSenha());
        $this->assertEquals($this->props->ativo, $this->sut->ativo);
        $this->assertEquals($this->props->emailVerificado, $this->sut->emailVerificado);
        $this->assertEquals($this->props->dataCriacao, $this->sut->dataCriacao);
        $this->assertEquals($this->props->perfis, $this->sut->perfis);
    }

    public function testContrutorMetodoReconstruct(): void
    {
        $this->sut = Usuario::reconstruct($this->props, $this->id);

        $this->assertEquals($this->props->nome, $this->sut->nome);
        $this->assertEquals($this->props->email, $this->sut->email);
        $this->assertEquals($this->props->senha, $this->sut->getSenha());
        $this->assertEquals($this->props->ativo, $this->sut->ativo);
        $this->assertEquals($this->props->emailVerificado, $this->sut->emailVerificado);
        $this->assertEquals($this->props->dataCriacao, $this->sut->dataCriacao);
        $this->assertEquals($this->props->perfis, $this->sut->perfis);
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

    public function testGetterEmail(): void
    {
        $this->assertEquals($this->sut->email, $this->props->email);
        $this->assertIsString($this->sut->email);
    }

    public function testGetterAtivo(): void
    {
        $this->assertEquals($this->sut->ativo, $this->props->ativo);
        $this->assertIsBool($this->sut->ativo);
    }

    public function testGetterEmailVerificado(): void
    {
        $this->assertEquals($this->sut->ativo, $this->props->ativo);
        $this->assertIsBool($this->sut->ativo);
    }

    public function testGetterDataCriacao(): void
    {
        $this->assertEquals($this->sut->dataCriacao, $this->props->dataCriacao);
        $this->assertIsString($this->sut->dataCriacao);
    }

    public function testGetterPerfis(): void
    {
        $this->assertEquals($this->sut->perfis, $this->props->perfis);
        $this->assertIsArray($this->sut->perfis);
    }

    public function testGetterSenha(): void
    {
        $this->assertEquals($this->sut->getSenha(), $this->props->senha);
        $this->assertInstanceOf(Senha::class, $this->sut->getSenha());
    }

    public function testSetterNome()
    {
        $this->sut->setNome('Novo nome');
        $this->assertEquals('Novo nome', $this->sut->nome);
        $this->assertIsString($this->sut->nome);
    }

    public function testSetterEmail()
    {
        $this->sut->setEmail('novo-email@email.com');
        $this->assertEquals('novo-email@email.com', $this->sut->email);
        $this->assertIsString($this->sut->email);
    }

    public function testSetterSenha()
    {
        $this->sut->setSenha(Senha::create('nova-senha'));
        $this->assertTrue(Senha::check('nova-senha', $this->sut->getSenha()->toValue()));
        $this->assertIsString($this->sut->email);
    }
}
