<?php

namespace App\Models;

use App\Models\Escopos\UserEscopo;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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
    public function getDataVencimentoAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y');
    }

    public function setDataVencimentoAttribute($value)
    {
        $this->attributes['data_vencimento'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class);
    }
}
