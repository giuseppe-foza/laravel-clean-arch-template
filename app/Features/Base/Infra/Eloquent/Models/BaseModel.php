<?php
declare(strict_types=1);

namespace App\Features\Base\Infra\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $data_criacao
 * @property string $data_alteracao
 * @property string $data_exclusao
 */
abstract class BaseModel extends Model
{
    const string REGISTRO_ID = 'registro_id';
    const string USUARIO_CRIACAO_ID = 'usuario_criacao_id';
    const string USUARIO_ALTERACAO_ID = 'usuario_alteracao_id';
    const string USUARIO_EXCLUSAO_ID = 'usuario_exclusao_id';
    const string DATA_CRIACAO = 'data_criacao';
    const string DATA_ALTERACAO = 'data_alteracao';
    const string DATA_EXCLUSAO = 'data_exclusao';


    protected $table = 'auditoria.registro';
    protected $primaryKey = self::REGISTRO_ID;
    public $timestamps = false;
    protected $casts = [
        self::DATA_CRIACAO => 'timestamp',
        self::DATA_ALTERACAO => 'timestamp',
        self::DATA_EXCLUSAO => 'timestamp',
    ];
    public $hidden = [
        self::REGISTRO_ID,
        self::USUARIO_CRIACAO_ID,
        self::USUARIO_ALTERACAO_ID,
        self::USUARIO_EXCLUSAO_ID,
    ];

    public function __construct(array $attributes = [])
    {
        $this->mergeFillable([
            self::USUARIO_CRIACAO_ID,
            self::USUARIO_ALTERACAO_ID,
            self::USUARIO_EXCLUSAO_ID,
        ]);

        parent::__construct($attributes);
    }

    public static function campoCompleto(string $campo): string
    {
        return self::nomeTabela().'.'.$campo;
    }

    public static function nomeTabela(): string
    {
        return (new static)->getTable();
    }
}
