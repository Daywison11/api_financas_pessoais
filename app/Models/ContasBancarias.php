<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContasBancarias extends Model
{
    use HasFactory;

    // protected $table = 'contas_bancarias';

    protected $fillable = ['user_id', 'tipo_conta', 'banco', 'numero_conta', 'saldo'];

    public function usuario()
    {
        return $this->belongsTo(User::class);
    }

    public function transacoes()
    {
        return $this->hasMany(Transacao::class);
    }

    /**
     * Escopo para filtrar por código de usuário.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $codigo_usuario
     * @return \Illuminate\Database\Eloquent\Builder
     */

    public function scopeCodigoUsuario($query, $codigo_usuario)
    {
        return $query->where('user_id', $codigo_usuario);
    }
}
