<?php
declare(strict_types=1);

namespace App\Features\Usuario\Infra\Memory;

use App\Features\Usuario\Domain\Entities\Usuario;
use App\Features\Usuario\Domain\Props\UsuarioProps;
use App\Features\Usuario\Domain\Repositories\UsuarioRepository;

class MemoryUsuarioRepository implements UsuarioRepository {
    public function __construct(private array $usuarios = [])
    {
        $this->usuarios = [];
    }

    public function listarTodos(): array
    {
        return $this->usuarios;
    }

    public function listarPorId(int $id): ?Usuario
    {
        // TODO: Implement listarPorId() method.
    }

    public function listarPorEmail(string $email): ?Usuario
    {
        // TODO: Implement listarPorEmail() method.
    }

    public function inserir(UsuarioProps $usuarioProps): Usuario
    {
        // TODO: Implement inserir() method.
    }

    public function atualizar(Usuario $usuario): Usuario
    {
        // TODO: Implement atualizar() method.
    }
}
