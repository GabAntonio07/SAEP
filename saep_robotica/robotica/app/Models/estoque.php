<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class estoque extends Model
{
    protected $fillable = [
        'codigo',
        'nome',
        'fabricante',
        'preco',
        'quantidade',
        'nivel_minimo',
        'numero_de_serie',
        'tempo_de_vida',
        'localizacao'
    ];

    public function Estoque(): BelongsTo
    {
        return $this->BelongsTo(Estoque::class, 'codigo');
    }
    
}
