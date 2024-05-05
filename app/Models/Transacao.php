<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transacao extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'conta_id', 'tipo_transacao', 'valor', 'descricao', 'data_transacao'];

    public function usuario()
    {
        return $this->belongsTo(User::class);
    }

    public function contaBancaria()
    {
        return $this->belongsTo(ContaBancaria::class);
    }
}
