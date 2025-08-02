<?php
declare(strict_types=1);

namespace App\Features\Usuario\Infra\Eloquent\Models;

use App\Features\Base\Infra\Eloquent\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id
 * @property string $nome
 * @property string $chave
 * @property bool $ativo
 */
class EloquentPerfilModel extends BaseModel
{
    const string ID = 'id';
    const string NOME = 'nome';
    const string CHAVE = 'chave';
    const string ATIVO = 'ativo';

    protected $table = 'usuario.perfil';

    protected $primaryKey = self::ID;

    protected $fillable = [
        self::ID,
        self::NOME,
        self::CHAVE,
        self::ATIVO,
    ];

    public function usuarios(): BelongsToMany
    {
        return $this->belongsToMany(
            EloquentUsuarioModel::class,
            'usuario.usuario_perfil',
            'perfil_id',
            'usuario_id',
        );
    }
}
