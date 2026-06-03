<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class liga extends Model
{
    protected $fillable = [
        'codigo',
        'nome',
        'fabricante',
        'preco',
        'quantidade',
        'nivel_minimo',
    ];
}
