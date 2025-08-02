<?php
declare(strict_types=1);

namespace App\Features\Usuario\Infra\Eloquent\Models;

use App\Features\Base\Infra\Eloquent\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Collection;

/**
 * @property int $id
 * @property string $nome
 * @property string $email
 * @property string $senha
 * @property bool $ativo
 * @property bool $email_verificado
 * @property string $data_criacao
 * @property Collection<int, EloquentPerfilModel> $perfis
 */
class EloquentUsuarioModel extends BaseModel
{
    const string ID = 'id';
    const string NOME = 'nome';
    const string EMAIL = 'email';
    const string SENHA = 'senha';
    const string ATIVO = 'ativo';
    const string EMAIL_VERIFICADO = 'email_verificado';
    const string PERFIS = 'perfis';

    protected $table = 'usuario.usuario';

    protected $primaryKey = self::ID;

    protected $fillable = [
        self::ID,
        self::NOME,
        self::EMAIL,
        self::SENHA,
        self::ATIVO,
        self::EMAIL_VERIFICADO,
    ];

    public function perfis(): BelongsToMany
    {
        return $this->belongsToMany(
            EloquentPerfilModel::class,
            'usuario.usuario_perfil',
            'usuario_id',
            'perfil_id',
        );
    }
}
