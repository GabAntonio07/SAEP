<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carga extends Model
{
    protected $fillable = [
        'nome',
        'codigo',
        'fabricante',
        'preco',
        'quantidade',
        'nivel_minimo',
        'peso',
        'largura',
        'altura',
        'comprimento',
        'destino',
        'status',
    ];

    public function Carga(): BelongsTo
    {
        return $this->BelongsTo(Carga::class, 'codigo');
    }
}
