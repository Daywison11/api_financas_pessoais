<?php

namespace App\Models;

use App\Models\Escopos\UserEscopo;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Despesas extends Model
{
    use HasFactory;

    protected $table = 'despesas';
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

}
