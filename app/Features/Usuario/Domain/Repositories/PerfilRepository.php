<?php
declare(strict_types=1);

namespace App\Features\Usuario\Domain\Repositories;

use App\Features\Usuario\Domain\Entities\Perfil;

interface PerfilRepository
{
    public function listarPorId(int $id): ?Perfil;
    public function listarPorChave(string $chave): ?Perfil;
}
