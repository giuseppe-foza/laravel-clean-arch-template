<?php
declare(strict_types=1);

namespace App\Features\Usuario\Domain\Repositories;

use App\Features\Usuario\Domain\Entities\Usuario;
use App\Features\Usuario\Domain\Props\UsuarioProps;

interface UsuarioRepository
{
    public function listarTodos(): array;
    public function listarPorId(int $id): ?Usuario;
    public function listarPorEmail(string $email): ?Usuario;
    public function inserir(UsuarioProps $usuarioProps): Usuario;
    public function atualizar(Usuario $usuario): Usuario;
}
