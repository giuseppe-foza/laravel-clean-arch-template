<?php
declare(strict_types=1);

namespace App\Features\Usuario\Presentation\Validators;

use App\Features\Base\Presentation\FormRequest\AppFormRequest;

class UsuarioFiltrosBuscaValidator extends AppFormRequest
{
    public function rules(): array
    {
        return $this->mergePaginationOrderRules([
            'nome'  => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
        ]);
    }

    public function attributes(): array
    {
        return $this->mergePaginationOrderAttributes([
            'nome'  => 'Nome',
            'email' => 'E-mail',
        ]);
    }
}
