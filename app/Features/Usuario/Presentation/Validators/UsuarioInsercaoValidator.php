<?php
declare(strict_types=1);

namespace App\Features\Usuario\Presentation\Validators;

use App\Features\Base\Presentation\FormRequest\AppFormRequest;

class UsuarioInsercaoValidator extends AppFormRequest
{
    public function rules(): array
    {
        return [
            'nome'              => ['required', 'string', 'max:255'],
            'email'             => ['required', 'email', 'max:255'],
            'perfilId'          => ['required', 'integer', 'min:1'],
            'senha'             => ['required', 'string', 'min:6'],
            'confirmacaoSenha'  => ['required', 'same:senha'],
        ];
    }

    public function attributes(): array
    {
        return [
            'nome'             => 'Nome',
            'email'            => 'E-mail',
            'perfilId'         => 'Perfil',
            'senha'            => 'Senha',
            'confirmacaoSenha' => 'Confirmação de Senha',
        ];
    }
}
