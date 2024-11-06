<?php

namespace App\Models;

use App\Models\Escopos\UserEscopo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContasBancarias extends Model
{
    use HasFactory;
    protected $table = 'contas_bancarias';
    protected $primaryKey = 'id';
    protected $guarded = [];


    protected static function booted(): void
    {
        static::addGlobalScope(new UserEscopo);
        static::creating(function ($despesas) {
            $user_id = auth()->user() ? auth()->user()->id : app('user_id');
            $despesas->user_id = $user_id;
        });
        
    }

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

}
