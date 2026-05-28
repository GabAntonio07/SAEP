<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class hardware extends Model
{
    protected $table = 'hardware';

    protected $fillable = [
        'codigo',
        'nome',
        'fabricante',
        'quantidade',
        'nivel_minimo',
        'end_mac',
        'end_ip',
        'voltagem',
        'manutencao',
        'alerta'
    ];

    public function movimentacao()
    {
        return $this->hasMany(estoque::class);
    }
}