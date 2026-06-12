<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Gestao extends Model
{
    protected $fillable =[
        'codigo',
        'tipo',
        'quantidade',
        'data',
    ];

    public function Carga(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Carga::class, 'codigo');
    }
}

