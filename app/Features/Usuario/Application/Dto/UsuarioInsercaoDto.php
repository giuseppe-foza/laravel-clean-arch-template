<?php
declare(strict_types=1);

namespace App\Features\Usuario\Application\Dto;

class UsuarioInsercaoDto
{
    public string $nome;
    public string $email;
    public string $senha;
    public int $perfilId;
}
