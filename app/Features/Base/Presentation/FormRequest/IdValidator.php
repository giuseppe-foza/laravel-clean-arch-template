<?php
declare(strict_types=1);

namespace App\Features\Base\Presentation\FormRequest;

class IdValidator extends AppFormRequest
{
    public function rules(): array
    {
        return [
            'id' => ['required', 'integer', 'min:1'],
        ];
    }

    public function messages(): array
    {
        return [
            'id.required' => 'O ID é obrigatório.',
            'id.integer'  => 'O ID precisa ser um número inteiro.',
            'id.min'      => 'O ID deve ser maior que zero.',
        ];
    }
}
