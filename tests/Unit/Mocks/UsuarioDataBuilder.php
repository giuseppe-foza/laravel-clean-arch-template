<?php
declare(strict_types=1);

namespace Tests\Unit\Mocks;

use App\Features\Base\Domain\ValueObjects\Date;
use App\Features\Usuario\Domain\Props\PerfilProps;
use App\Features\Usuario\Domain\Props\UsuarioProps;
use App\Features\Usuario\Domain\ValueObjects\Senha;

class UsuarioDataBuilder
{
    public static function getUsuarioProps(): UsuarioProps
    {
        return new UsuarioProps(
            nome: 'Teste',
            email: 'teste@email.com',
            senha: Senha::create('senha'),
            ativo: true,
            emailVerificado: true,
            dataCriacao: Date::now()->toValue(),
            perfis: []
        );
    }

    public static function getPerfilProps(): PerfilProps
    {
        return new PerfilProps(
            nome: 'Administrador',
            chave: 'ADMINISTRADOR',
            ativo: true,
            dataCriacao: Date::now()->toValue(),
        );
    }
}
