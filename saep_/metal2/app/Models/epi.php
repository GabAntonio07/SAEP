<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class epi extends Model
{
    protected $table = 'epis';

    protected $fillable = [
        'codigo',
        'nome',
        'fabricante',
        'preco',
        'quantidade',
        'nivel_minimo',
        'certificado',
        'data_validade',
    ];

    protected $casts = [
        'data_validade' => 'date',
    ];

    public function movimentos(): HasMany
    {
        return $this->hasMany(Movimento::class, 'epi_id');
    }
}
