<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class liga extends Model
{
    protected $table = 'ligas';

    protected $fillable = [
        'codigo',
        'nome',
        'fabricante',
        'preco',
        'quantidade',
        'nivel_minimo',
        'tipo_liga',
        'ponto_fusao',
        'peso_toneladas',
    ];

    public function movimentos(): HasMany
    {
        return $this->hasMany(Movimento::class, 'liga_id');
    }
}
