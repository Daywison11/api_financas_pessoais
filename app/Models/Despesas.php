<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Despesas extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'titulo', 'descricao', 'categoria', 'valor', 'data_vencimento', 'status'];

    public function usuario()
    {
        return $this->belongsTo(User::class);
    }
}
