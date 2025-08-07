<?php
declare(strict_types=1);

namespace App\Features\Base\Presentation\FormRequest;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

abstract class AppFormRequest extends FormRequest
{
    const string PAGINA            = 'pagina';
    const string POR_PAGINA        = 'porPagina';
    const string CAMPO_ORDENACAO   = 'campoOrdenacao';
    const string DIRECAO_ORDENACAO = 'direcaoOrdenacao';

    public array $sorting = [];

    public bool $requiredPagination = false;

    private ?string $columnsNameRules;

    abstract public function rules(): array;

    public function authorize(): bool
    {
        return true;
    }

    protected function failedValidation(Validator $validator): void
    {
        $errors = new ValidationException($validator)->errors();

        throw new HttpResponseException(
            response()->json([
                'message' => 'Dados inválidos.',
                'errors'  => $errors,
                'statusCode' => Response::HTTP_BAD_REQUEST,
            ], Response::HTTP_BAD_REQUEST)
        );
    }

    /**
     * Permite validar parâmetros de rota como `id`, etc.
     */
    public function validationData(): array
    {
        return array_merge($this->route()?->parameters() ?? [], $this->all());
    }

    /**
     * Define valores default para paginação, se ausentes.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            self::PAGINA     => $this->input(self::PAGINA, 1),
            self::POR_PAGINA => $this->input(self::POR_PAGINA, 50),
        ]);
    }

    public function mergePaginationOrderRules(array $filters = []): array
    {
        $this->setColumnsNameRules();

        $paginationRules  = $this->requiredPagination ? 'required|integer|min:1' : 'nullable|integer|min:1';
        $direcaoRules     = 'nullable|string|in:asc,desc';

        $paginationOrderRules = [
            self::PAGINA              => $paginationRules,
            self::POR_PAGINA          => $paginationRules,
            self::DIRECAO_ORDENACAO   => $direcaoRules,
            self::CAMPO_ORDENACAO     => $this->getColumnsNameRules(),
        ];

        return array_merge($paginationOrderRules, $filters);
    }

    public function mergePaginationOrderAttributes(array $attributes = []): array
    {
        $paginationOrderAttributes = [
            self::PAGINA              => 'Página',
            self::POR_PAGINA          => 'Itens por página',
            self::CAMPO_ORDENACAO     => 'Campo de ordenação',
            self::DIRECAO_ORDENACAO   => 'Direção da ordenação',
        ];

        return array_merge($paginationOrderAttributes, $attributes);
    }

    private function setColumnsNameRules(): void
    {
        if (count($this->sorting) > 0) {
            $allowedColumns = implode(',', $this->sorting);
            $this->columnsNameRules = "nullable|string|in:$allowedColumns";
        } else {
            $this->columnsNameRules = 'nullable|string';
        }
    }

    private function getColumnsNameRules(): string
    {
        return $this->columnsNameRules ?? 'nullable|string';
    }
}

