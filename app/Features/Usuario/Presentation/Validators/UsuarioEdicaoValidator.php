<?php
declare(strict_types=1);

namespace App\Features\Usuario\Presentation\Validators;

use App\Features\Base\Presentation\FormRequest\AppFormRequest;

class UsuarioEdicaoValidator extends AppFormRequest
{
    public function rules(): array
    {
        return [
            'id'               => ['required', 'integer', 'min:1'],
            'nome'             => ['required', 'string', 'max:255'],
            'email'            => ['required', 'email', 'max:255'],
            'perfilId'         => ['required', 'integer', 'min:1'],
        ];
    }

    public function attributes(): array
    {
        return [
            'id'       => 'ID',
            'nome'     => 'Nome',
            'email'    => 'E-mail',
            'perfilId' => 'Perfil',
        ];
    }
}
