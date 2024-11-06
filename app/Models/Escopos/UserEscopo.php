<?php

namespace App\Models\Escopos;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class UserEscopo implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        try {
            $user = null;

            if (Auth::check()) {
                $user = Auth::user()->id;
            } else if (app()->bound('user')) {
                $user = app('user');
            }

            if ($user !== null) {
                $builder->where('user_id', $user);
            }
        } catch (\Throwable $e) {
            echo $e->getMessage();
        }
    }
}
