<?php
declare(strict_types=1);

namespace App\Features\Base\Domain\Props;

final class PaginacaoOrdenacao
{
    public const string DIRECAO_ASC = 'ASC';
    public const string DIRECAO_DESC = 'DESC';
    public const array DIRECOES_VALIDAS = [
        self::DIRECAO_ASC,
        self::DIRECAO_DESC,
    ];

    private int $pagina;
    private int $porPagina;
    private string $campoOrdenacao;
    private string $direcaoOrdenacao;

    public function getPagina(): int
    {
        return $this->pagina;
    }

    public function getPorPagina(): int
    {
        return $this->porPagina;
    }

    public function getCampoOrdenacao(): string
    {
        return $this->campoOrdenacao;
    }

    public function getDirecaoOrdenacao(): string
    {
        return $this->direcaoOrdenacao;
    }

    public function setPagina(int $pagina): void
    {
        if ($pagina < 1) {
            $pagina = 1;
        }

        $this->pagina = $pagina;
    }

    public function setPorPagina(int $porPagina): void
    {
        if ($porPagina < 1 || $porPagina > 50) {
            $porPagina = 50;
        }

        $this->porPagina = $porPagina;
    }

    public function setCampoOrdenacao(?string $campo): void
    {
        if(!$campo) {
            $campo = 'data_criacao';
        }

        $this->campoOrdenacao = $campo;
    }

    public function setDirecaoOrdenacao(?string $direcao = null): void
    {
        if(!$direcao) {
            $direcao = 'DESC';
        }

        $direcao = strtoupper($direcao);

        if (!in_array($direcao, self::DIRECOES_VALIDAS, true)) {
            $direcao = 'DESC';
        }

        $this->direcaoOrdenacao = $direcao;
    }
}
