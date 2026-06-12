<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estoque extends Model
{
    protected $fillable = [
        'nome',
        'codigo',
        'fabricante',
        'preco',
        'quantidade',
        'nivel_minimo',
        'remetente',
        'peso',
        'status',
    ];

    public function Estoque()
    {
        return $this->hasMany(Encomenda::class);
    }

}
